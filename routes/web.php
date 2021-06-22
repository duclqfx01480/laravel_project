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

// 20. Resource Route to HobbyController

// 21. Lấy hobbies từ CSDL và thêm Navigate cho hobbies
Route::resource('hobby', \App\Http\Controllers\HobbyController::class);
// Trong HobbyController, viết trong hàm index để lấy hobbies từ CSDL
// Thêm navigation cho hobby trong resources/views/layouts/app.blade.php

// 22. Output/ Display Hobbies
// Trong views, tạo một thư mục mới, tên hobby
// Trong hobby vừa tạo, thêm mới 'index.blade.php', copy nội dung của home.blade.php qua file này.

// 23. Form for new Hobbies
// Trong hobby/index.blade.php, tạo thêm 1 div => 1 anchor link sẽ trỏ đến '/hobby/create'
// Trong HobbyController, phần create, viết hàm trả về view hobby.create
// Trong views/hobby/create.blade.php, viết code cho view để tạo form nhập Hobby

// 24. Lưu Hobby (nhập dữ liệu từ form thêm hobby mới)
// Step 1: Action & Method của from: Trong views/hobby/create.blade.php, form => thêm action & method cho form
// Step 2: CSRF Token: Thêm @csrf ở dòng 14 (phần này sẽ tạo ra một input ẩn, có name là _token)
// Step 3: Trong HobbyController, phần store
// Sau khi viết code cho phương thức store xong, nếu chạy sẽ phát sinh lỗi ...mass assignment ..., do đó cần bước 4
// Step 4: Viết thêm hàm fillable trong Hobby Model (app\Models\Hobby) để cho phép mass assignment


// 25. Server-side Validation of Laravel with validate()
// Cần validate trước khi thêm dữ liệu vào CSDL. Ví dụ: Nếu form để trống và nhấn thêm Hobby -> phát sinh lỗi (column cannot be null)
// Viết Validation trong HobbyController, trong phương thức store

// 26. Validation- Hiển thị lỗi của các input không thỏa
// Tìm alert của bootstrap, copy code một alert nào đó
// Trong views/layouts/app.blade.php, trước @yield('content'),
// => bổ sung 1 div sau đó paste code đã copy ở trên ra và viết code (xem thêm  trong app.blade.php)
// Các thông báo lỗi được lưu ở: resources/lang/en/validation.php
// => Có thể tinh chỉnh các thông báo này. Ví dụ: dòng 89, dòng 101, thêm bold cho :attribute in ra
// [Option] Chỉnh sửa font trong resources/sass/_variables.scss, phần $font-family-sans-serif => Sau đó chạy lại npm run dev

// 27. Validate: Lỗi của từng input riêng biệt
// Quay lại form cần chỉnh sửa ở 'resources/views/hobby/create.blade.php'
// Thêm class border cho input name và thêm small [text], xem thêm ở trong form

// 28. Tạo thông báo đã thêm Hobby thành công
// * Trong resources/views/layouts/app.blade.php
// - Thêm hai alert (success và warning) trước phần về validation
// * Trong HobbyController, phần store, khi return trả về thêm ->with() và truyền vào message_success







