<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\BlogCategoryController;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\Home\ContactController;
use App\Http\Controllers\Home\FooterController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\home\PortfolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::controller(DemoController::class)->group(function () {
    Route::get('/', 'homeMain')->name('home');
    Route::get('/contact', 'contact')->name('contact.page');
});

// all admin routes
Route::middleware(['auth'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'profile')->name('admin.profile');
        Route::get('/edit/profile', 'editProfile')->name('edit.profile');
        Route::post('/store/profile', 'storeProfile')->name('store.profile');
        Route::get('/change/password', 'changePassword')->name('change.password');
        Route::post('/update/password', 'updatePassword')->name('update.password');
    });
});

// all Home Slide routes
Route::controller(HomeSliderController::class)->group(function () {
    Route::get('/home/slide', 'homeSlider')->name('home.slide');
    Route::post('/update/slider', 'updateSlider')->name('update.slider');
});

// all About routes
Route::controller(AboutController::class)->group(function () {
    Route::get('/about/page', 'aboutPage')->name('about.page');
    Route::post('/update/about', 'updateAbout')->name('update.about');
    Route::get('/about', 'homeAbout')->name('home.about');

    Route::get('/about/multi/image', 'aboutMultiImage')->name('about.multi.image');
    Route::post('/store/multi/image', 'storeMultiImage')->name('store.multi.image');
    Route::get('/all/multi/image', 'allMultiImage')->name('all.multi.image');
    Route::get('/edit/multi/image/{id}', 'editMultiImage')->name('edit.multi.image');
    Route::post('/update/multi/image', 'updateMultiImage')->name('update.multi.image');
    Route::get('/delete/multi/image/{id}', 'deleteMultiImage')->name('delete.multi.image');
});

// all Portfolio routes
Route::controller(PortfolioController::class)->group(function () {
    Route::get('/all/portfolio', 'allPortfolio')->name('all.portfolio');
    Route::get('/add/portfolio', 'addPortfolio')->name('add.portfolio');
    Route::post('/store/portfolio', 'storePortfolio')->name('store.portfolio');

    Route::get('/edit/portfolio/{id}', 'editPortfolio')->name('edit.portfolio');
    Route::post('/update/portfolio', 'updatePortfolio')->name('update.portfolio');
    Route::get('/delete/portfolio/{id}', 'deletePortfolio')->name('delete.portfolio');
    Route::get('/portfolio/details/{id}', 'portfolioDetails')->name('portfolio.details');
    Route::get('/portfolio', 'homePortfolio')->name('home.portfolio');
});

// all Blog Category routes
Route::controller(BlogCategoryController::class)->group(function () {
    Route::get('/all/blog/category', 'allBlogCategory')->name('all.blog.category');
    Route::get('/add/blog/category', 'addBlogCategory')->name('add.blog.category');
    Route::Post('/store/blog/category', 'storeBlogCategory')->name('store.blog.category');
    Route::get('/edit/blog/category/{id}', 'editBlogCategory')->name('edit.blog.category');
    Route::post('/update/blog/category/{id}', 'updateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'deleteBlogCategory')->name('delete.blog.category');
});

// all Blog routes
Route::controller(BlogController::class)->group(function () {
    Route::get('/all/blog', 'allBlog')->name('all.blog');
    Route::get('/add/blog', 'addBlog')->name('add.blog');
    Route::post('/store/blog', 'storeBlog')->name('store.blog');
    Route::get('/edit/blog/{id}', 'editBlog')->name('edit.blog');
    Route::post('/update/blog', 'updateBlog')->name('update.blog');
    Route::get('/delete/blog/{id}', 'deleteBlog')->name('delete.blog');

    Route::get('/blog/details/{id}', 'blogDetails')->name('blog.details');
    Route::get('/category/blog/{id}', 'categoryBlog')->name('category.blog');

    Route::get('/blog', 'homeBlog')->name('home.blog');
});

// all Footer routes
Route::controller(FooterController::class)->group(function () {
    Route::get('/footer/setup', 'footerSetup')->name('footer.setup');
    Route::post('/update/footer', 'updateFooter')->name('update.footer');
});

// all Contact routes
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'contact')->name('contact.me');
    Route::post('/store/message', 'storeMessage')->name('store.message');
    Route::get('/Contact/message', 'ContactMessage')->name('Contact.message');
    Route::get('/delete/message/{id}', 'deleteMessage')->name('delete.message');
});
















Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
