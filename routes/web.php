<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 6. Laravel UI
// Cài đặt ui cho dự án
// composer require laravel/ui
// Thêm giao diện vue và có chức năng đăng nhập
// php artisan ui vue --auth
// npm install
// npm run dev // để compile js và style vào thư mục public

// 7. Tích hợp CSS và JS tự viết
// Bổ sung js tự viết
// Trong resources/js/app.js, bổ sung require('./custom')
// resources/js, thêm custom.js -> viết custom.js
// (...)

// Bổ sung css tự viết
// Trong resources/sass/app.scss, bổ sung @import 'custom'
// resources/sass, thêm custom.scss -> viết custom.scss
// (...)

// Chạy 'npm run dev' để compile lại js và scss
// Nếu chạy 'npm run watch'
// => bất cứ khi nào lưu file scss và js tự viết (custom) thì Laravel tự compile lại scss và js

// 8. Cài đặt Font-Awesome
// npm install --save @fortawesome/fontawesome-free
// Trong resources/sass/app.scss, bổ sung phần import cho Font-Awesome
// 'npm run watch' sẽ tự động compile
// Test Font-Awesome
// Ví dụ: Bổ sung một icon trước nút Login
// Trong views/auth/login.blade.php, dòng 57
// <i class="fas fa-caret-square-right"></i>

// 9. Kết nối CSDL và Migration
// Tên CSDL: myhobbies
// Thêm thông tin CSDL vào file .env
// Khi có các sửa đổi trong .env phải xóa cache
// php artisan config:cache
// Chạy migration : php artisan migrate


