<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hobbies = Hobby::all();
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
            'description'=>$request['description']
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {
        //
    }
}
