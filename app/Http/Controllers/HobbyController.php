<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;

class HobbyController extends Controller
{

    // 46@ 2:39 - Chỉ user đã đăng nhập mới được thêm mới một hobby
    // Thêm một constructor
    public function __construct(){
        // Nếu không đăng nhập thì chỉ được phép truy cập phương thức index và show
        $this->middleware('auth')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //$hobbies = Hobby::all();
        // 45.Pagination - Phân trang
        //$hobbies = Hobby::paginate(10);

        // 47. Sắp xếp hobbies theo ngày tạo
        $hobbies = Hobby::orderBy('created_at', 'DESC')->paginate(10);

        return view('hobby.index')->with(['hobbies'=>$hobbies]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('hobby.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // 25. Server-side validation
        // 69. Comment this out
//        $request->validate([
//            'name' => 'required|min:3',
//            'description' => 'required|min:5',
//        ]);
        // Phần validate này sẽ xóa (clear) dữ liệu của field nếu các trường không thỏa
        // Để không xóa các field, trong views/hobby/create.blade.php, ở input name, bổ sung value="{{old('name')}}"
        // Tương tự cho input description

        // 69 - Copy ở Update lên, xem thêm ở Update Method
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required|min:5',
            'image' => 'mimes:jpeg,jpg,bmp,png,gif',
        ]);

        // 24. Lưu Hobby
        // Tạo ra một hobby mới, dựa vào name và description của request
        $hobby = new Hobby([
            'name'=>$request['name'],
            'description'=>$request['description'],
            'user_id' => auth()->id() // 46. Lưu thêm user_id, và cần chỉnh sửa trong Model để cho phép lưu (fillable)
        ]);
        // Lưu hobby
        $hobby->save();

        // 69- Dời phần này xuống sau $hobby, nếu thêm trước thì $hobby chưa được tạo
        if($request->image){
            $this->saveImages($request->image, $hobby->id);
        }

        // Gọi this-> phương thức index, mà trong phương thức index lại trả về view hobby.index
        // => Chuyển hướng đến trang index

        /* 57 comment out phần này
        return $this->index()->with([
            // 28. Tạo thông báo đã thêm Hobby thành công
            'message_success'=> 'The hobby <b>' . $hobby->name . '</b> was added successfull'
        ]);
        */

        /* 57. thay thế phần đã bị comment trên bằng phần dưới dây */
        return redirect('/hobby/' . $hobby->id)->with([
            // Gởi kèm thông báo nhắc nhở thêm tag cho bài viết
            // Phương thức show (bên dưới) sẽ gởi kèm cả message_warning này
            'message_warning' => 'Please add some tags for this post'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {
        // 55. Fetch tất cả các tags exists
        $allTags = Tag::all();
        $usedTags = $hobby->tags;
        $availableTags = $allTags->diff($usedTags);
        // Khi có availableTags -> gửi nó cho Front-end ở return bên dưới

        // 29. Tạo trang xem chi tiết
        // Trả về view hobby.show, do đó viết blade của show.blade.php trong resources/views/hobby/show.blad.php
        // Truyền thêm $hobby qua cho view
        return view('hobby.show')->with([
            'hobby'=>$hobby,
            'availableTags' => $availableTags, // 55. gửi $availableTags cho front-end, sau đó qua view hobby/show.blade.php và hiển thị lên
            'message_success' => Session::get('message_success'), // truyền thêm cả thông báo
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        // 86 Nếu cho phép update thì mới cho xem form edit
        abort_unless(Gate::allows('update', $hobby), 403);

        return view('hobby.edit')->with([
            'hobby'=>$hobby,
            'message_success' => Session::get('message_success'),
            'message_warning' => Session::get('message_warning')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hobby $hobby)
    {
        // 86
        abort_unless(Gate::allows('update', $hobby), 403);

        // Copy từ phương thức store xuống
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required|min:5',
            'image' => 'mimes:jpeg,jpg,bmp,png,gif',
            // 66. Bổ sung validate cho image upload
            // 'image' => 'mimes:jpeg,jpg,bmp,png,gif|max:2' => cho phép upload tối đa 2KB
            // 'image' => 'mimes:jpeg,jpg,bmp,png,gif|dimensions:max-width=200,min-height=100' => validate kích thước ảnh
            // 'image' => 'mimes:jpeg,jpg,bmp,png,gif|dimensions:ratio=4/3' => validate tỷ lệ ảnh
        ]);

        // 67, 68, 69
        if($request->image){
            $this->saveImages($request->image, $hobby->id);
        }

        // Sửa thành update
        $hobby->update([
            'name'=>$request['name'],
            'description'=>$request['description']
        ]);

        //$hobby->save(); - comment out/ delete dòng này

        return $this->index()->with([
            'message_success'=> 'The hobby <b>' . $hobby->name . '</b> was updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {

        // 86
        abort_unless(Gate::allows('delete', $hobby), 403);

        $oldName = $hobby->name;
        $hobby->delete();

        // Chuyển hướng đến index và thông báo xóa thành công
        return $this->index()->with([
            'message_success' => 'The hobby <b>' . $oldName . '</b> was deleted.'
        ]);
    }

    // 69
    public function saveImages($imageInput, $hobby_id){
        $image = Image::make($imageInput);

        if($image->width() > $image->height()){
            // 68
            // landcape image
            $image->widen(1200)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg")
                ->widen(400)->pixelate(12)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg");

            // 68. Tạo hình ảnh thumbnail
            // Lấy lại instance của hình ảnh tải lên
            $image = Image::make($imageInput);
            $image->widen(60)
                ->save(public_path() . '/img/hobbies/' . $hobby_id . '_thumb.jpg');
        }else{
            // 68
            // portrait image
            $image->heighten(900)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg")
                ->heighten(400)->pixelate(12)
                ->save(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg");

            // 68. Tạo hình ảnh thumbnail
            // Lấy lại instance của hình ảnh tải lên
            $image = Image::make($imageInput);
            $image->heighten(60)
                ->save(public_path() . '/img/hobbies/' . $hobby_id . '_thumb.jpg');
        }
    }

    // 71. Xóa hình ảnh
    public function deleteImages($hobby_id){
        // Delete large image
        if(file_exists(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg")){
            unlink(public_path() . "/img/hobbies/" . $hobby_id . "_large.jpg");
        }

        // Delete pixelated image
        if(file_exists(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg")){
            unlink(public_path() . "/img/hobbies/" . $hobby_id . "_pixelated.jpg");
        }

        // Delete thumb image
        if(file_exists(public_path() . "/img/hobbies/" . $hobby_id . "_thumb.jpg")){
            unlink(public_path() . "/img/hobbies/" . $hobby_id . "_thumb.jpg");
        }

        // after deletion, return
        return back()->with([
            'message_success' => 'The image was deleted'
        ]);

    }




}
