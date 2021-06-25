<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 25. Server-side validation
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required|min:5',
        ]);
        // Phần validate này sẽ xóa (clear) dữ liệu của field nếu các trường không thỏa
        // Để không xóa các field, trong views/hobby/create.blade.php, ở input name, bổ sung value="{{old('name')}}"
        // Tương tự cho input description

        // 24. Lưu Hobby
        // Tạo ra một hobby mới, dựa vào name và description của request
        $hobby = new Hobby([
            'name'=>$request['name'],
            'description'=>$request['description'],
            'user_id' => auth()->id() // 46. Lưu thêm user_id, và cần chỉnh sửa trong Model để cho phép lưu (fillable)
        ]);
        // Lưu hobby
        $hobby->save();

        // Gọi this-> phương thức index, mà trong phương thức index lại trả về view hobby.index
        // => Chuyển hướng đến trang index
        return $this->index()->with([
            // 28. Tạo thông báo đã thêm Hobby thành công
            'message_success'=> 'The hobby <b>' . $hobby->name . '</b> was added successfull'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {
        // 29. Tạo trang xem chi tiết
        // Trả về view hobby.show, do đó viết blade của show.blade.php trong resources/views/hobby/show.blad.php
        // Truyền thêm $hobby qua cho view
        return view('hobby.show')->with([
            'hobby'=>$hobby
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        //
        return view('hobby.edit')->with([
            'hobby'=>$hobby
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
        // Copy từ phương thức store xuống
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required|min:5',
        ]);

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
        $oldName = $hobby->name;
        $hobby->delete();

        // Chuyển hướng đến index và thông báo xóa thành công
        return $this->index()->with([
            'message_success' => 'The hobby <b>' . $oldName . '</b> was deleted.'
        ]);
    }
}
