<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Tablecategory;
use App\Models\Order;
use App\Models\Concerns\HasApiBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    use HasApiBranch;

    /**
     * Get tables with categories and status information
     */
    public function getTablesWithStatus()
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        // Get table categories with their tables
        $query = Tablecategory::with(['tables' => function($query) {
            $query->with(['latestOrder' => function($orderQuery) {
                $orderQuery->select('id', 'orders.table_id', 'status', 'is_paid', 'created_at', 'updated_at')
                    ->with(['items' => function($itemQuery) {
                        $itemQuery->select('id', 'order_id', 'item_id', 'quantity', 'price', 'total_price')
                            ->with(['item:id,name']);
                    }, 'customer:id,name,phone,address,vehicle_number']);
            }]);
        }]);
        $query = $this->applyBranchFilter($query);
        
        $tableCategories = $query->get();
        
        // Format the response with status information
        $formattedCategories = $tableCategories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'branch_id' => $category->branch_id,
                'tables' => $category->tables->map(function ($table) {
                    $status = $this->getTableStatus($table);
                    return [
                        'id' => $table->id,
                        'name' => $table->name,
                        'tablecategory_id' => $table->tablecategory_id,
                        'branch_id' => $table->branch_id,
                        'status' => $status['status'],
                        'status_label' => $status['label'],
                        'status_class' => $status['class'],
                        'last_order' => $table->latestOrder ? [
                            'id' => $table->latestOrder->id,
                            'status' => $table->latestOrder->status,
                            'is_paid' => $table->latestOrder->is_paid,
                            'created_at' => $table->latestOrder->created_at,
                            'updated_at' => $table->latestOrder->updated_at,
                            'customer' => $table->latestOrder->customer ? [
                                'id' => $table->latestOrder->customer->id,
                                'name' => $table->latestOrder->customer->name,
                                'phone' => $table->latestOrder->customer->phone,
                                'address' => $table->latestOrder->customer->address,
                                'vehicle_number' => $table->latestOrder->customer->vehicle_number,
                            ] : null,
                            'items' => !$table->latestOrder->is_paid ? $table->latestOrder->items->map(function($orderItem) {
                                return [
                                    'id' => $orderItem->id,
                                    'item_id' => $orderItem->item_id,
                                    'item_name' => $orderItem->item->name,
                                    'quantity' => $orderItem->quantity,
                                    'price' => $orderItem->price,
                                    'total_price' => $orderItem->total_price,
                                ];
                            }) : null,
                        ] : null,
                    ];
                })
            ];
        });
        
        return $this->successResponse($formattedCategories, 'Tables with status retrieved successfully');
    }

    /**
     * Get single table with status information
     */
    public function getTableWithStatus($id)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Table::with(['tablecategory', 'latestOrder' => function($orderQuery) {
            $orderQuery->with(['items' => function($itemQuery) {
                $itemQuery->with(['item:id,name']);
            }, 'customer:id,name,phone,address,vehicle_number']);
        }])
            ->where('id', $id);
        $query = $this->applyBranchFilter($query);
        
        $table = $query->first();
        
        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not found or not accessible'
            ], 404);
        }

        $status = $this->getTableStatus($table);
        
        $formattedTable = [
            'id' => $table->id,
            'name' => $table->name,
            'tablecategory_id' => $table->tablecategory_id,
            'branch_id' => $table->branch_id,
            'tablecategory' => [
                'id' => $table->tablecategory->id,
                'name' => $table->tablecategory->name,
            ],
            'status' => $status['status'],
            'status_label' => $status['label'],
            'status_class' => $status['class'],
            'last_order' => $table->latestOrder ? [
                'id' => $table->latestOrder->id,
                'status' => $table->latestOrder->status,
                'is_paid' => $table->latestOrder->is_paid,
                'created_at' => $table->latestOrder->created_at,
                'updated_at' => $table->latestOrder->updated_at,
                'customer' => $table->latestOrder->customer ? [
                    'id' => $table->latestOrder->customer->id,
                    'name' => $table->latestOrder->customer->name,
                    'phone' => $table->latestOrder->customer->phone,
                    'address' => $table->latestOrder->customer->address,
                    'vehicle_number' => $table->latestOrder->customer->vehicle_number,
                ] : null,
                'items' => !$table->latestOrder->is_paid ? $table->latestOrder->items->map(function($orderItem) {
                    return [
                        'id' => $orderItem->id,
                        'item_id' => $orderItem->item_id,
                        'item_name' => $orderItem->item->name,
                        'quantity' => $orderItem->quantity,
                        'price' => $orderItem->price,
                        'total_price' => $orderItem->total_price,
                    ];
                }) : null,
            ] : null,
        ];

        return $this->successResponse($formattedTable, 'Table with status retrieved successfully');
    }

    /**
     * Get table status information
     */
    private function getTableStatus($table)
    {
        $latestOrder = $table->latestOrder;
        
        if (!$latestOrder) {
            return [
                'status' => 'available',
                'label' => 'Available',
                'class' => 'bg-light text-dark'
            ];
        }
        
        $status = $latestOrder->status;
        
        return match ($status) {
            'occupied' => [
                'status' => 'occupied',
                'label' => 'Occupied',
                'class' => 'bg-danger text-white'
            ],
            'saved' => [
                'status' => 'saved',
                'label' => 'Saved',
                'class' => 'bg-success text-dark'
            ],
            'saved_and_printed' => [
                'status' => 'saved_and_printed',
                'label' => 'Saved & Printed',
                'class' => 'bg-success text-white'
            ],
            'saved_and_billed' => [
                'status' => 'saved_and_billed',
                'label' => 'Saved & Billed',
                'class' => 'bg-primary text-white'
            ],
            'kot' => [
                'status' => 'kot',
                'label' => 'KOT',
                'class' => 'bg-success text-white'
            ],
            'kot_print' => [
                'status' => 'kot_print',
                'label' => 'KOT Printed',
                'class' => 'bg-success text-white'
            ],
            'hold' => [
                'status' => 'hold',
                'label' => 'Hold',
                'class' => 'bg-secondary text-white'
            ],
            default => [
                'status' => 'available',
                'label' => 'Available',
                'class' => 'bg-light text-dark'
            ],
        };
    }
}
