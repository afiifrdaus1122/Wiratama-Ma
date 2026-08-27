<?php

use Illuminate\Support\Facades\Route;

// Guest/User Routes (Public)
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
Route::get('/products/autocomplete', [App\Http\Controllers\Frontend\ProductController::class, 'autocomplete'])->name('products.autocomplete');
Route::get('/products/{slug}', [App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');
Route::post('/products/{slug}/rfq', [App\Http\Controllers\Frontend\ProductController::class, 'sendRfq'])->name('products.rfq.send')->middleware('throttle:public-actions');
Route::get('/gallery', [App\Http\Controllers\Frontend\GalleryController::class, 'index'])->name('gallery.index');
Route::get('/about', [App\Http\Controllers\Frontend\HomeController::class, 'about'])->name('about');
Route::get('/sitemap.xml', [App\Http\Controllers\Frontend\SitemapController::class, 'index'])->name('sitemap');

// Cart Routes
Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\Frontend\CartController::class, 'add'])->name('cart.add')->middleware('throttle:public-actions');
Route::patch('/cart/update', [App\Http\Controllers\Frontend\CartController::class, 'update'])->name('cart.update')->middleware('throttle:public-actions');
Route::delete('/cart/remove', [App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('cart.remove')->middleware('throttle:public-actions');
Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/checkout/success/{order:invoice_number}', [App\Http\Controllers\Frontend\CheckoutController::class, 'success'])->name('checkout.success');

// Customer Auth Routes
Route::get('/login', [App\Http\Controllers\Frontend\AuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/login', [App\Http\Controllers\Frontend\AuthController::class, 'login'])->middleware('throttle:auth');
Route::get('/register', [App\Http\Controllers\Frontend\AuthController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/register', [App\Http\Controllers\Frontend\AuthController::class, 'register'])->middleware('throttle:auth');
Route::post('/logout', [App\Http\Controllers\Frontend\AuthController::class, 'logout'])->name('customer.logout');


// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:auth');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
// Customer Protected Routes
Route::middleware('auth')->group(function () {
    // Customer Dashboard & Profile (No longer managing checkout via app, strictly for account settings or previous orders if any)
    Route::get('/my-account', [App\Http\Controllers\Frontend\CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/my-profile', [App\Http\Controllers\Frontend\CustomerController::class, 'editProfile'])->name('customer.profile');
    Route::put('/my-profile', [App\Http\Controllers\Frontend\CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/my-orders/{order:invoice_number}', [App\Http\Controllers\Frontend\CustomerController::class, 'orderDetail'])->name('customer.order_detail');
    Route::get('/my-orders/{order:invoice_number}/quotation.pdf', [App\Http\Controllers\Frontend\CustomerController::class, 'downloadQuotation'])->name('customer.quotation.pdf');
    Route::post('/my-orders/{order:invoice_number}/accept-quotation', [App\Http\Controllers\Frontend\CustomerController::class, 'checkoutQuotation'])->name('customer.quotation.accept');
});

// Admin Authentication Routes
Route::get('admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('throttle:auth');
Route::post('admin/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('/', function() { return redirect()->route('admin.dashboard'); });
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::get('orders/export', [App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('admin-users', App\Http\Controllers\Admin\AdminUserController::class)->only(['index', 'store', 'destroy']);
    
    // Company Profile / Website & Menu Settings
    Route::get('/company-profile', [App\Http\Controllers\Admin\CompanyProfileController::class, 'edit'])->name('company-profile.edit');
    Route::get('/about-us', [App\Http\Controllers\Admin\CompanyProfileController::class, 'edit'])->name('about-us.edit');
    Route::get('/menu-settings', [App\Http\Controllers\Admin\CompanyProfileController::class, 'edit'])->name('menu-settings.edit');
    Route::put('/company-profile', [App\Http\Controllers\Admin\CompanyProfileController::class, 'update'])->name('company-profile.update');
    
    // Additional Company Profile Menus
    Route::resource('hero-banners', App\Http\Controllers\Admin\HeroBannerController::class)->except(['show']);
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class)->except(['show']);
    Route::resource('client-logos', App\Http\Controllers\Admin\ClientLogoController::class)->except(['show']);
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class)->except(['show']);
    Route::resource('article-categories', App\Http\Controllers\Admin\ArticleCategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
    Route::resource('highlights', App\Http\Controllers\Admin\HighlightEventController::class)->except(['show']);
    Route::resource('product-questions', App\Http\Controllers\Admin\ProductQuestionController::class)->only(['index', 'update', 'destroy']);
    Route::resource('contacts', App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
});

// Frontend Articles
Route::get('/blog', [App\Http\Controllers\Frontend\ArticleController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [App\Http\Controllers\Frontend\ArticleController::class, 'show'])->name('blog.show');

// Frontend Contact
Route::get('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('contact.store')->middleware('throttle:public-actions');

// Frontend Product Questions
Route::post('/products/{product}/question', [App\Http\Controllers\Frontend\ProductQuestionController::class, 'store'])->name('products.question.store')->middleware(['auth', 'throttle:public-actions']);

// Midtrans Webhook
Route::post('/midtrans/callback', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'callback'])->middleware('throttle:public-actions');
