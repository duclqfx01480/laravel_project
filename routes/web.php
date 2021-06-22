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

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| SECTION 3: FRONT-END AND LOGIN SET UP
|--------------------------------------------------------------------------
*/

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

// 11 . Test chức năng Quên mật khẩu
// File .env -> thiết lập các thông tin liên quan đến email
// https://mailtrap.io/ -> Testing email
// Chạy lại php artisan config:cache

// 13. Tạo trang static và điều hướng
// Copy nguồn trang home.blade.php sang info.blade.php và starting_page.blade.php
// Điều hướng Route gốc '/' trả về starting_page
Route::get('/', function () {
    return view('starting_page');
});

// Tạo thêm Route cho info
Route::get('/info', function(){
    return view('info');
});

// Thêm thanh điều hướng (Navigation Bar)
// Xem 'resources/views/layouts/app.blade.php'
// Phần Left Side Of Navbar -> thêm các link vào left nav bar
// Chạy 'npm run watch' để chuẩn bị compile cho một số thay đổi về giao diện
// Viết thêm css cho left nav bar ở custom.scss

// 14. Tạo Template cho các trang
// Ở 'resources/views/layouts/app.blade.php'
// Thiết lập tiêu đề dynamic cho từng trang
// - 'app.blade.php', phần thiết lập title=> dynamic title bằng cách @yield ra page_title
// - Ở từng trang blade.php (info và starting_page), thêm section page_title tương ứng

// Thiết lập meta description cho từng trang
// - 'app.blade.php', thêm meta description
// - Ở từng trang blade.php (info và starting_page), thêm section page_description tương ứng


/*
|--------------------------------------------------------------------------
| SECTION 4: DATABASE QUERIES (CRUD)
|--------------------------------------------------------------------------
*/
// 17. MVC và các lệnh Make
// - Tạo Model Hobby
// php artisan make:model Hobby -a
//  => Tên model luôn là số ít và viết hoa chữ cái đầu
//  => Tùy chọn -a sẽ tạo Model, Factory, Migration, Seeder, resource Controller

// 18. Migration hobbies table
// - Chỉnh sửa Migration 'create_hobbies_table''
// Thêm cột name và description & chạy php artisan migrate

// - Take a look HobbyController -> resource Controller functions

// 19. Routing to functions và sử dụng placeholder
Route::get('/test/{name}/{age}', [\App\Http\Controllers\HobbyController::class, 'index']);




