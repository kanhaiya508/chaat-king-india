<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Staff;
use App\Models\Table;
use App\Models\Tablecategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OrderFormComponent extends Component
{
    public $categories;
    public $tablecategories;

    public bool $markPaidNoAmount = false;
    public $selectedItem;
    public $selectedItemVariants;
    public $selectedItemAddons = [];
    public $showModal = false;

    public $cart = [];

    public $discountValue = 0;     // Input box se
    public $isPercent = false;     // Toggle (true = %, false = ₹)
    public $discountTotal = 0;     // Auto calculated
    public $subtotal = 0;
    public $finalTotal = 0;


    public $customerName;
    public $phone;
    public $address;
    public $vehicle_number;
    public $orderRemark;
    public $customerId = null;


    public $selectedTableId;
    public $showForm = true;
    public $isEditing = false;
    public $isDelivery = false;
    public $isRunningOrder = false;
    public $order_id = null;
    public $saveandsettlement = false;
    public $payments = [];
    public $runningOrders = [];

    public ?string $deliveryPartnerName = null;
    public ?string $deliveryPartnerPhone = null;
    public ?string $deliveryLocation = null;
    public ?float $deliveryDistance = null;
    public string $activeTab = 'items-tab';
    public string $type = '';
    public string $tabelcat = '';
    public string $tabelnam = '';
    public int $activeCategoryTab = 0; // Track which category tab is active


    public $staff_id = null;
    public $staffList = [];

    public $write_off = 0;           // user confirm karega
    public $write_off_reason = '';   // optional note
    public $maxWriteOff = 500;        // policy: max ₹10 waive (aap change kar sakte ho)


    protected $listeners = ['openOrderForm'];

    public function mount()
    {


        $this->staffList = Staff::all();
        $this->tablecategories = Tablecategory::with('tables')->get();
        $this->categories = Category::with('items.variants', 'items.addons')->get();
    }

    public function openModal($itemId)
    {
        $this->selectedItem = Item::with('variants', 'addons')->find($itemId);
        $this->selectedItemVariants = null;
        $this->selectedItemAddons = [];
        $this->showModal = true;
    }

    public function selectCategoryTab($tabIndex)
    {
        $this->activeCategoryTab = $tabIndex;
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedItem = null;
    }

    public function addSelectedItemToCart()
    {
        // Check if variants are required
        if ($this->selectedItem->variants->count() && !$this->selectedItemVariants) {
            throw ValidationException::withMessages([
                'selectedItemVariants' => 'Please select a variant.',
            ]);
        }
        $this->cart[] = [
            'item' => $this->selectedItem,
            'variant_id' => $this->selectedItemVariants,
            'addon_ids' => $this->selectedItemAddons,
            'quantity' => 1,
            'remark' => '',
        ];

        $this->closeModal();
        $this->calculateTotals();
    }

    public function updatedCart()
    {
        $this->calculateTotals();
    }

    public function removeItem($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // reindex
        $this->calculateTotals();
    }

    public function applyDiscount()
    {
        // Apply logic: update totals, cart, etc.
        if ($this->isPercent) {
            $this->discountTotal = ($this->subtotal * $this->discountValue) / 100;
        } else {
            $this->discountTotal = $this->discountValue;
        }
        $this->calculateTotals();
        // Recalculate total, grand total etc.
    }

    public function increaseQty($index)
    {
        if (isset($this->cart[$index]['quantity'])) {
            $this->cart[$index]['quantity'] += 1;
        }
        $this->calculateTotals();
    }

    public function decreaseQty($index)
    {
        if (isset($this->cart[$index]['quantity']) && $this->cart[$index]['quantity'] > 1) {
            $this->cart[$index]['quantity'] -= 1;
        }
        $this->calculateTotals();
    }


    // Agar final subtotal nikalna hai to
    public function getDiscountAmountProperty()
    {
        if ($this->isPercent) {
            return ($this->subtotal * $this->discountValue) / 100;
        }
        return $this->discountValue;
    }

    public function getTotalAfterDiscountProperty()
    {
        return $this->subtotal - $this->discountAmount;
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;

        foreach ($this->cart as $item) {
            $variant = $item['item']->variants->firstWhere('id', $item['variant_id']);
            $variantPrice = $variant ? $variant->price : 0;

            $addonTotal = 0;
            if (!empty($item['addon_ids'])) {
                foreach ($item['addon_ids'] as $addonId) {
                    $addon = $item['item']->addons->firstWhere('id', $addonId);
                    $addonTotal += $addon ? $addon->price : 0;
                }
            }

            $quantity = $item['quantity'] ?? 1;
            $this->subtotal += ($variantPrice + $addonTotal) * $quantity;
        }

        // Always compute based on current values
        $this->discountTotal = $this->isPercent
            ? ($this->subtotal * $this->discountValue) / 100
            : $this->discountValue;

        $this->finalTotal = max($this->subtotal - $this->discountTotal, 0);
    }

    public function updatedPhone($value)
    {
        if ($value) {
            $customer = Customer::where('phone', $value)->first();
            if ($customer) {
                $this->customerId = $customer->id;
                $this->customerName = $customer->name;
                $this->address = $customer->address;
            } else {
                $this->customerId = null;
                $this->customerName = '';
                $this->address = '';
            }
        }
    }


    public function saveOrderData($status = 'saved')
    {
        // Validation: Ensure at least one item is in cart
        $this->validate([
            'cart' => 'required|array|min:1',
        ], [
            'cart.required' => 'At least one item must be added to the order.',
            'cart.min' => 'At least one item must be added to the order.',
        ]);

        DB::beginTransaction();
        try {
            // If customer doesn't exist, create new customer
            // If customerId is not set, and at least one of the fields is filled
            if (
                !$this->customerId &&
                (
                    !empty($this->customerName) ||
                    !empty($this->phone) ||
                    !empty($this->vehicle_number) ||
                    !empty($this->address)
                )
            ) {
                $customer = Customer::create([
                    'name' => $this->customerName,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'vehicle_number' => $this->vehicle_number,

                ]);
                $this->customerId = $customer->id;
            }


            // If editing existing order
            if ($this->isEditing) {
                $order = Order::findOrFail($this->order_id);
                $order->update([
                    'customer_id' => $this->customerId,

                    'staff_id' => $this->staff_id,
                    'subtotal' => $this->subtotal,
                    'discount' => $this->discountTotal,
                    'total' => $this->finalTotal,
                    'remark' => $this->orderRemark,
                    'status' => $status,
                    'type' => $this->type,
                    // ✅ New Delivery fields
                    'delivery_partner_name'  => $this->deliveryPartnerName,
                    'delivery_partner_phone' => $this->deliveryPartnerPhone,
                    'delivery_location'      => $this->deliveryLocation,
                    'delivery_distance'      => $this->deliveryDistance,
                ]);

                // Remove old items
                $order->items()->delete();
            } else {
                // Create a new order
                $order = Order::create([
                    'customer_id' => $this->customerId,

                    'staff_id' => $this->staff_id,
                    'subtotal' => $this->subtotal,
                    'discount' => $this->discountTotal,
                    'total' => $this->finalTotal,
                    'remark' => $this->orderRemark,
                    'table_id' => $this->selectedTableId,
                    'status' => $status,
                    'type' => $this->type,
                    'delivery_partner_name'  => $this->deliveryPartnerName,
                    'delivery_partner_phone' => $this->deliveryPartnerPhone,
                    'delivery_location'      => $this->deliveryLocation,
                    'delivery_distance'      => $this->deliveryDistance,
                ]);


                $this->order_id = $order->id ?? null;
            }

            // Add items to order (custom method)
            $this->addItemsToOrder($order);

            DB::commit();
            return $order->id;
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return null;
        }
    }







    public function saveOrder()
    {
        $orderId = $this->saveOrderData('saved');

        if ($orderId) {
            $this->resetOrderForm();
            $this->dispatch('show-toast', 'Order saved successfully!');
        } else {
            session()->flash('error', 'Failed to save order.');
        }
    }

    public function saveOrderAndPrint()
    {
        $orderId = $this->saveOrderData('saved_and_printed');
        if ($orderId) {
            $this->resetOrderForm();
            $this->dispatch('orderSavedForPrint', $orderId);
        } else {
            session()->flash('error', 'Failed to save & print order.');
        }
    }

    public function saveOrderAndBill()
    {
        $orderId = $this->saveOrderData('saved_and_billed');

        if ($orderId) {
            $this->resetOrderForm();
            $this->dispatch('orderSavedForBilling', $orderId);
        } else {
            session()->flash('error', 'Failed to save & bill order.');
        }
    }

    public function saveOrderAsKOT()
    {
        $orderId = $this->saveOrderData('kot');

        if ($orderId) {
            $this->resetOrderForm();
            $this->dispatch('orderSavedForKOT', $orderId);
        } else {
            session()->flash('error', 'Failed to save as KOT.');
        }
    }

    public function saveOrderAsKOTAndPrint()
    {
        $orderId = $this->saveOrderData('kot_print');

        if ($orderId) {
            $this->resetOrderForm();
            $this->dispatch('orderSavedForKOTPrint', $orderId);
        } else {
            session()->flash('error', 'Failed to save KOT & print.');
        }
    }

    // saveandsettlement
    public function saveandSettlement()
    {

        $this->payments = [
            ['mode' => 'Cash', 'amount' => $this->finalTotal, 'transaction_id' => '', 'note' => '']
        ];

        $this->saveandsettlement = true;
    }

    public function closeSettlement()
    {
        $this->saveandsettlement = false;
    }


    public function saveOrderAsHold()
    {
        $orderId = $this->saveOrderData('hold');

        if ($orderId) {
            $this->resetOrderForm();
            $this->dispatch('orderSavedAsHold', $orderId);
        } else {
            session()->flash('error', 'Failed to hold order.');
        }
    }

    public function resetOrderForm()
    {
        $this->selectedItem = null;
        $this->selectedItemVariants = null;
        $this->selectedItemAddons = [];
        $this->showModal = false;
        $this->showForm = true;
        $this->showForm = true;
        $this->isRunningOrder = false;
        $this->cart = [];
        $this->payments = [];

        $this->discountValue = 0;
        $this->isPercent = false;
        $this->discountTotal = 0;
        $this->subtotal = 0;
        $this->finalTotal = 0;

        $this->customerName = '';
        $this->phone = '';
        $this->address = '';
        $this->orderRemark = '';
        $this->customerId = null;
    }

    public function openOrderForm($tableId)
    {
        $this->selectedTableId = $tableId;
        $order = Order::where('table_id', $tableId)
            ->where('status', '!=', 'paid')->first();
        $tabledata = Table::where('id', $tableId)->first();
        $this->tabelcat = $tabledata->tablecategory->name ?? '';
        $this->tabelnam = $tabledata->name ?? '';
        if ($order) {
            $this->order_id = $order->id ?? null;
            $this->isEditing = true;
            $this->setOrderValues($order);
        } else {
            $this->cart = [];
        }
        $this->showForm = false;
        $this->type = 'dine-in';
    }

    public function viewOrder($orderId)
    {
        $this->order_id = $orderId;
        $order = Order::where('id', $orderId)
            ->where('status', '!=', 'paid')
            ->first();

        if ($order) {
            $this->isEditing = true;
            $this->setOrderValues($order);
        } else {
            $this->cart = [];
        }
        $this->showForm = false;
    }

    public function RunningOrder()
    {
        // Agar already running orders mode me hai, to tables view me wapas jao
        if ($this->isRunningOrder) {
            $this->isRunningOrder = false;
            $this->runningOrders = [];
        } else {
            // Running orders fetch karo
            $this->runningOrders = Order::whereNotIn('status', ['paid', 'closed'])->get();
            $this->isRunningOrder = true;
        }
    }



    public function Takeaway()
    {

        $this->showForm = false;
        $this->type = 'takeaway';
    }
    public function Delivery()
    {

        $this->showForm = false;
        $this->isDelivery = true;
        $this->type = 'delivery';
    }


    public function setOrderValues(Order $order)
    {
        $this->cart = $order->items->map(function ($item) {
            return [
                'item' => $item->item,
                'variant_id' => $item->variant_id,
                'addon_ids' => json_decode($item->addon_ids, true) ?? [],
                'quantity' => $item->quantity,
                'remark' => $item->remark,
            ];
        })->toArray();

        $this->customerId = null;
        $this->customerName = $order->customer->name ?? '';
        $this->phone = $order->customer->phone ?? '';
        $this->address = $order->customer->address ?? '';
        $this->orderRemark = $order->remark ?? '';
        $this->discountValue = $order->discount;
        $this->isPercent = false;
        $this->subtotal = $order->subtotal ?? 0;
        $this->finalTotal = $order->discount ? $order->total : $this->subtotal;

        $this->calculateTotals();
    }

    public function addItemsToOrder($order)
    {
        foreach ($this->cart as $item) {
            $variant = $item['item']->variants->firstWhere('id', $item['variant_id']);
            $variantPrice = $variant ? $variant->price : 0;
            $addonTotal = 0;
            $addonIds = [];

            if (!empty($item['addon_ids'])) {
                foreach ($item['addon_ids'] as $addonId) {
                    $addon = $item['item']->addons->firstWhere('id', $addonId);
                    if ($addon) {
                        $addonTotal += $addon->price;
                        $addonIds[] = $addon->id;
                    }
                }
            }

            $quantity = $item['quantity'] ?? 1;

            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['item']->id ?? null,
                'variant_id' => $item['variant_id'] ?? null,
                'item_name' => $item['item']->name,
                'quantity' => $quantity,
                'price' => $variantPrice,
                'total_price' => ($variantPrice + $addonTotal) * $quantity,
                'addon_ids' => json_encode($addonIds),
                'remark' => $item['remark'] ?? null,
            ]);
        }
    }


    public function getTableStatusClass($status)
    {
        return match ($status) {
            'occupied' => 'bg-danger text-white',
            'saved' => 'bg-success text-dark',
            'saved_and_printed' => 'bg-danger text-white',
            'saved_and_billed' => 'bg-primary text-white',
            'kot' => 'bg-success text-white',
            'kot_print' => 'bg-teal text-white',
            'hold' => 'bg-secondary text-white',
            default => 'bg-light text-dark',
        };
    }


    public function addPaymentRow()
    {
        $this->payments[] = ['mode' => '', 'amount' => '', 'transaction_id' => '', 'note' => ''];
    }

    public function removePaymentRow($index)
    {
        unset($this->payments[$index]);
        $this->payments = array_values($this->payments); // Reindex
    }

    public function getPaymentTotalProperty()
    {
        return collect($this->payments)->sum(function ($payment) {
            return (float) $payment['amount'];
        });
    }



    public function savePayments()
    {
        // 1) अगर "no amount" वाला checkbox ON है तो payments validation skip करो
        if (!$this->markPaidNoAmount) {
            $this->validate([
                'payments.*.mode'   => 'required|string',
                'payments.*.amount' => 'required|numeric|min:1',
            ]);
        }

        if ($this->markPaidNoAmount) {
            // बिना amount, सीधे paid mark कर रहे हैं
            $orderId = $this->saveOrderData('paid'); // तुम्हारा existing method

            if ($orderId) {
                // कोई payment row save नहीं करेंगे
                $order = \App\Models\Order::find($this->order_id);
                if ($order) {
                    $order->is_paid = true;                  // ⬅️ नया फील्ड
                    $order->write_off = $this->write_off ?? 0; // चाहो तो 0 ही रहने दो
                    $order->write_off_reason = $this->write_off_reason ?: null;
                    $order->save();
                }

            $this->resetOrderForm();
            $this->saveandsettlement = false;
            $this->dispatch('show-toast', 'Order marked paid (no payment).');
            $this->dispatch('orderSettlementCompleted', $this->order_id);
            } else {
                session()->flash('error', 'Failed to save payment.');
            }
            return;
        }

        // 2) Normal flow (amount के साथ)
        $short  = $this->shortfall;
        $change = $this->changeDue;

        if ($short > 0) {
            if (!$this->write_off) $this->write_off = $short;

            if (abs($this->write_off - $short) > 0.01) {
                session()->flash('error', 'Write-off amount must match the shortfall.');
                return;
            }
            if ($this->write_off > $this->maxWriteOff) {
                session()->flash('error', "Write-off exceeds allowed limit (Max ₹{$this->maxWriteOff}).");
                return;
            }
        } else {
            $this->write_off = 0;
        }

        $orderId = $this->saveOrderData('paid');

        if ($orderId) {
            foreach ($this->payments as $payment) {
                if (empty($payment['mode']) || empty($payment['amount'])) continue;

                \App\Models\OrderPayment::create([
                    'order_id'       =>  $this->order_id,
                    'mode'           =>  $payment['mode'],
                    'amount'         =>  $payment['amount'],
                    'transaction_id' =>  $payment['transaction_id'] ?? null,
                    'note'           =>  $payment['note'] ?? null,
                ]);
            }

            $order = \App\Models\Order::find($this->order_id);
            if ($order) {
                $order->is_paid          = true; // ⬅️ normal में भी true
                $order->write_off        = $this->write_off ?? 0;
                $order->write_off_reason = $this->write_off_reason ?: ($this->write_off ? 'Cash short' : null);
                $order->save();
            }

            $this->resetOrderForm();
            $this->saveandsettlement = false;
            $this->dispatch('show-toast', 'Order paid (write-off applied if any).');
            $this->dispatch('orderSettlementCompleted', $this->order_id);
        } else {
            session()->flash('error', 'Failed to save payment.');
        }
    }




    // Shortfall (kitna kam mila)
    public function getShortfallProperty()
    {
        $short = $this->finalTotal - $this->paymentTotal;
        return $short > 0 ? round($short, 2) : 0;
    }

    // Change due (zyada mila to wapas)
    public function getChangeDueProperty()
    {
        $extra = $this->paymentTotal - $this->finalTotal;
        return $extra > 0 ? round($extra, 2) : 0;
    }

    // (optional) अगर checkbox toggle हो तो payments साफ कर दो
    public function updatedMarkPaidNoAmount($val)
    {
        if ($val) {
            // UI साफ-सुथरा रखने के लिए rows हटा दें (ज़रूरत हो तो रख सकते हैं)
            $this->payments = [
                ['mode' => '', 'amount' => null, 'transaction_id' => null, 'note' => null],
            ];
            // write_off / change वगैरह reset (ताकि validations न टकराएँ)
            $this->write_off = 0;
            $this->discountValue = $this->discountValue; // no-op to keep totals as-is
        }
    }

    public function render()
    {
        return view('app.livewire.order-form-component')->layout('app.layouts.app');
    }
}
