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

// 29. Tạo trang xem chi tiết
// * Trong resources/views/hobby/index.blade.php
// Link: Ở dòng 14 để hiển thị ra li, ta sẽ bổ sung link ở đây -> thêm a, thuộc tính title, href và echo ra $hobby->id
// * Trong HobbyController, viết code phương thức show để hiển thị dữ liệu
// * Phương thức show trả về view resources/views/hobby/show.blade.php => cần viết code cho blade này
// *Trong show.blade.php, viết code trả về $hobby->name và $hobby->description


// 30. Cập nhật (edit) - tạo form edit và lấy thông tin
// info: php artisan route:list --name=hobby
// | Method    | URI                | Name          | Action                                       |
// +-----------+--------------------+---------------+----------------------------------------------+
// | GET|HEAD  | hobby/{hobby}/edit | hobby.edit    | App\Http\Controllers\HobbyController@edit    |

// * Trong index.blade.php -> Thêm một link edit ngay sau link chứa tên Hobby
// * Trong HobbyController -> phương thức edit
// * Trong view edit.blade.php, lấy dữ liệu trong $hobby đưa vào 2 fields (input)

// 31. Update - Thực hiện cập nhật vào DB
// info: PUT|PATCH | hobby/{hobby}      | hobby.update  | App\Http\Controllers\HobbyController@update
// * Form của edit.blade.php
//   - action là hobby/{{$hobby->id}}
//   - method là PUT hoặc PATCH ở dòng 18: @method('PUT')
// * Trong HobbyController -> phương thức update

// 32. Xóa dữ liệu (trong destroy của HobbyController)
// Info: | DELETE | hobby/{hobby} | hobby.destroy | App\Http\Controllers\HobbyController@destroy
// * Thêm form và nút Delete trong resources/views/hobby/index.blade.php
//   => Delete yêu cầu có phương thức delete nên cần triển khai một field ẩn => luôn cần 1 form
// * Trong HobbyController -> viết destroy


// *** CHALLENGE ***

// 33, 34- Challenge - Tạo tag
// * Trong app.blade.php, thêm điều hướng cho Tags
// * Tạo Model [và các file liên quan] cho Tag: php artisan make:model Tag -a
// * Migration: create_tags_table -> bổ sung 2 cột 'name' và 'style' kiểu string, chạy php artisan migrate
// * Viết Resource Route
Route::resource('tag', \App\Http\Controllers\TagController::class);
// * Viết các phương thức trong TagController
//   ** index
//   ** create
//   ** store
//   ** show - không cần
//   ** edit
//   ** update
//   ** destroy
// * Viết các view mà TagController trả về



/*
|--------------------------------------------------------------------------
| SECTION 5: DATABASE RELATIONSHIPS
|--------------------------------------------------------------------------
*/
// * QUAN HỆ 1-1: Một hobby chỉ thuộc về một user, một user có thể có nhiều hobby
// 36. Thêm cột user_id vào bảng hobbies
// Tạo Migration để thêm cột user_id vào bảng hobbies 'php artisan make:migration add_user_id_to_hobbies_table'
// Viết code cho phương thức up & down (xem thêm trong migration)
// Sau khi viết xong, chạy migrate 'php artisan migrate'

// * QUAN HỆ NHIỀU NHIỀU: Một hobby có thể có nhiều tag, một tag có thể được gắn trong nhiều hobby
// 37. Tạo bảng trung gian (bảng hobby_tag)
// Tạo Migration để tạo bảng trung gian: php artisan make:migration create_hobby_tag_table
// Thêm các cột vào Migration, thêm PK, FK, và chạy migrate

// 38. Bảng user - Bổ sung thêm cột motto (châm ngôn) và about_me (mô tả về bản thân)
// Trong Migration create_users_table, bổ sung 2 cột sau cột email
// refresh migrate: 'php artisan migrate:refresh'
// migrate:refresh sẽ xóa toàn bộ bảng (bao gồm dữ liệu) và chạy lại tất cả migration => tạo lại các bảng
// Chỉ dùng migrate:refresh khi ứng dụng chưa go live
// Không nên dùng: Khi đã go live, khi làm việc với các developer khác [vì có thể làm xóa hết dữ liệu]
//  -> Trong trường hợp đó, nên tạo mới một migration để thêm các cột cần thiết vào DB

// 39. Seed tags
// * Static Value Seeders (tags table)
// Trong database/seeders, mở DatabaseSeeder và TagSeeder
// DatabaseSeeder sẽ gọi TagSeeder, TagSeeder sẽ thêm dữ liệu vào bảng tags
// Có hai cách chạy seed:
// - php artisan db:seed
// - php artisan migrate:refresh --seed // sẽ thực hiện migrate:refresh, sau đó seed dữ liệu

// [  DatabaseSeeder -> TagSeeder, UserSeeder, HobbySeeder ]

// 40. Seed users [UserSeeder]
// * Dự án ban đầu tạo ra chưa có UserSeeder => cần tạo ra UserSeeder
// 'php artisan make:seeder UserSeeder'
// * Trong DatabaseSeeder, gọi UserSeeder
// * Viết code cho UserSeeder (UserSeeder sẽ gọi factory để tạo random user)
// * Chạy Seeder: php artisan migrate:refresh --seed (refresh lại migration và seed dữ liệu)


// 41. Sử dụng each để seed các bảng đã tạo quan hệ
// Mục tiêu: Với mỗi user sẽ tạo ra vài hobbies
// * Viết code cho HobbyFactory (tạo ra hobby gồm tên và mô tả)
// * Sửa lại UserSeeder, cứ mỗi lần seed một user sẽ seed thêm hobbies (thêm lệnh each sau create, xem thêm file UserSeeder)
// * Chạy lại 'php artisan migrate:refresh --seed'
//   => Đã seed xong dữ liệu cho các bảng (tag, user và hobby)

// * QUAN HỆ 1-NHIỀU (bảng users-hobbies)
//   - Bảng hobbies chưa có giá trị của cột user_id => tạo
//   - Quay lại UserSeeder, viết thêm vào create của seed hobbies để thêm user_id
//   - Chạy lại migrate:refresh --seed
//   => Tạo xong dữ liệu cho quan hệ 1-nhiều

// * QUAN HỆ NHIỀU-NHIỀU (bảng hobbies-tags)
// FYI 41@ 08:40
// Trong UserSeeder
// với mỗi create hobby, sẽ thực hiện thêm hobby_id và tag_id vào bảng hobby_tag
// (xem thêm ở UserSeeder)
// Chạy lại migrate:refresh --seed

// Note: Khi nào dùng DB Facade
// - Khi không có Model (ở đây có Model Hobby, Tag, User nhưng không có Model Hobby_Tag, và cũng không cần thiết)

// 42. Kết nối models với Eloquent Relationship
// Mở 3 Models: Hobby, Tag, User
// Xem thêm về phần viết quan hệ trong từng Model

// 43. Test Relationship trong Tinker
// Mở Command Prompt
// Khởi động Tinker: 'php artisan tinker'
//  * Tinker cho phép test CSDL mà không cần đến Front-end

// Một số lệnh với Tinker
// User::find(5)                            Tìm user có id là 5
// User::find(5)->hobbies                   Lấy ra các hobbies của user này
// User::find(5)->hobbies->pluck('name')    Chỉ lấy ra tên các hobbies

// Hobby::find(100)->user                   Lấy ra user của hobby có id 100
// Hobby::find(100)->tags->pluck('name')    Lấy ra tên các tags của hobby có id 100

// Tag::first()                             Lấy tag đầu tiên
// Tag::first()->hobbies->pluck('name')     Lấy ra tên các hobbies của tag đầu tiên
// Tag::first()->hobbies->count()           Đếm xem có bao nhiêu hobbies có gắn tag này
// Tag::all()->pluck('name')                Lấy ra tên của tất cả các tags
// Tag::all()->pluck('name')->toArray()     Chuyển collection thành mảng

// 44. Xem thêm ví dụ về Tinker và Collection


/*
|--------------------------------------------------------------------------
| SECTION 6: DATA OUTPUT AND DATA LINKING
|--------------------------------------------------------------------------
*/

// 45. Tạo phân trang
// * Mở HobbyController -> $hobbies = Hobby::paginate(10); để mỗi trang có 10 bài đăng hobbies
// * Trong resources/views/hobby/index.blade.php, thêm các nút chuyển trang trước nút thêm mới
// * Trong resources/views/hobby/show.blade.php, chỉnh sửa url cho nút bấm quay về

// 46. Thêm user_id vào hobby mỗi khi tạo mới hobby - dùng auth->id()
// * Trong HobbyController, viết thêm trong phương thức store để lưu thêm id, và chỉnh sửa fillable trong Hobby Model
// * Thêm chức năng, không đăng nhập thì chỉ được xem
//   - Trong HobbyController: Thêm một function __construct (xem thêm trong HobbyController)

// * Ẩn nút Edit và Delete nếu chưa đăng nhập (46@ 04:46)
//   - Trong index.blade.php của hobby, wrap hai nút này trong cặp @auth và @endauth
//   - Làm tương tự cho nút 'Add new Hobby'

// Đăng nhập để xem các nút này xuất hiện lại

// 47. Sắp xếp hobbies theo ngày tạo
// HobbyController, sắp xếp trong index

// Hiển thị ngày tạo hobby
// FYI: 'Carbon' package of php

// 48. Thêm tên người đăng và Hiển thị tổng số hobbies của người đó - $hobby->user->name + count()
// * Thêm tên người đăng của từng hobby
// * Hiển thị tổng số hobbies
// Xem trong index.blade.php

// 49. Cài đặt Laravel Debug Bar
// composer require barryvdh/laravel-debugbar --dev

// 50. Thêm tag vào trang index và trang show của Hobby
// Thêm vào index.blade.php
// Thêm vào show.blade.php

// CHALLENGE
// 51. Challenge
// Trong trang hiển thị danh sách hobbies, ở đó đã có tên người tạo. Tạo liên kết cho tên người dùng, khi nhấn vào
// ...sẽ mở ra trang xem chi tiết thông tin người dùng

// Tạo UserController
// Hiện đã có User Model nhưng chưa có Controller. Các Controller kia khi tạo cùng với Model, thêm option -a để tạo tất cả
// Ở đây sẽ tạo controller, thêm option -r để tạo các file resource
// thêm option --m và chỉ định tên Model để liên kết với User Model hiện có
// (dùng php artisan make:controller -h để xem chi tiết)
// php artisan make:controller UserController -r --model=User
// => Tạo UserController

// Tạo Resource route
Route::resource('user', \App\Http\Controllers\UserController::class);

// Trong hobby/index.blade.php, chổ hiển thị tên người dùng, thêm 1 link dẫn đến route để show user
// Viết view user/show.blade.php
// Phương thức show của UserController, trả về view và truyền thêm dữ liệu liên quan

// 52. Lọc hobbies theo tag (hobbyTagController)
// Tạo Controller mới: hobbyTagController
// php artisan make:controller hobbyTagController

// Trong hobbyTagController, viết hàm để hiển thị hobbies theo một tag nào đó

// Cần một route gọi đến hàm đó (vừa viết)
// Route nhận vào tag_id và sẽ được truyền vào hobbyTagController
Route::get('/hobby/tag/{tag_id}', [\App\Http\Controllers\hobbyTagController::class, "getFilteredHobbies"])->name('hobby_tag');
// Trong hobby/index.blade.php và show.blade.php ở phần hiển thị tag, thêm link đến route trên, truyền thêm tag_id

// Trong Model Tag, định nghĩa quan hệ (từ bảng tags đến bảng hobbies), cho phép lọc hobbies

// Để chỉnh sửa tiêu đề của phần hiển thị dữ liệu thành "Đang lọc dữ liệu cho tag..." thì truyền thêm $filter (là tag đang lọc) qua cho view
// Trong hobby/index.blade.php:
//  - Nếu nhận được $filter => chỉnh tiêu đề gì đó
//  - Nếu không nhận được $filter => hiển thị tiêu đề gì đó


// 54. Tùy chỉnh trang báo lỗi 404
// Copy các trang báo lỗi về views/errors
// php artisan vendor:publish --tag=laravel-errors
// Sau đó sửa mã HTML trong views/errors




