<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\Auth\RegisterController;
use App\Http\Controllers\App\Auth\LoginController;
use App\Http\Controllers\App\Auth\LogoutController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchSwitchController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerFcmTokenController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtherExpenseController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Livewire\CategoryManager;
use App\Livewire\EventBookingForm;
use App\Livewire\EventHallManager;
use App\Livewire\ItemFormComponent;
use App\Livewire\OrderFormComponent;
use App\Livewire\OrderListComponent;
use App\Livewire\OrderShowComponent;
use App\Livewire\SlotManager;
use App\Livewire\TablecategoryManager;
use App\Livewire\TableManager;



Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/service', [IndexController::class, 'service'])->name('service');
Route::get('/menu', [IndexController::class, 'menu'])->name('menu');
Route::get('/gallery', [IndexController::class, 'gallery'])->name('gallery');

Route::get('/orders/{order}/share', [OrderController::class, 'share'])->name('orders.share');




// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


Route::middleware('auth')->group(function () {
    Route::get('/branches/choose', [BranchSwitchController::class, 'choose'])->name('branches.choose');
    Route::post('/branches/switch/{branch}', [BranchSwitchController::class, 'switch'])->name('branches.switch');
});

// Authenticated Routes
Route::middleware(['auth', 'set.current.branch'])->group(function () {
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/categories', CategoryManager::class)->name('categories');

    Route::get('/item-form', ItemFormComponent::class)->name('item-form');
    Route::get('/order-form', OrderFormComponent::class)->name('order-form');
    Route::get('/order-show', OrderListComponent::class)->name('order.show');
    Route::get('/slots', SlotManager::class)->name('slots.manage');
    Route::get('/eventhalls', EventHallManager::class)->name('eventhalls.manage');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/event-booking-form', EventBookingForm::class)->name('event.booking.form');

    Route::get('/orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');


    Route::get('/tablecategories', TablecategoryManager::class)->name('tablecategories.manage');

    Route::get('/tables', TableManager::class)->name('tables.manage');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/push/send', [PushController::class, 'create'])->name('push.send.form');
    Route::post('/push/send', [PushController::class, 'store'])->name('push.send');

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'branches' => BranchController::class,
        'staff' => StaffController::class,
        'other-expenses' => OtherExpenseController::class,
    ]);
});










Route::middleware(['web', 'auth.customer'])->group(function () {
    Route::view('/push', 'push')->name('push.page'); // only for logged-in customers
    Route::post('/customer/fcm/token', [CustomerFcmTokenController::class, 'store'])
        ->name('customer.fcm.store');
});



// Public customer auth routes (example)
Route::get('/customer/login', [CustomerAuthController::class, 'showLoginForm'])
    ->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'login'])
    ->name('customer.login.post');
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])
    ->name('customer.logout');
