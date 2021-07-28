<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except(['index']);

        // Sử dụng AdminMiddleware
        $this->middleware('admin')->except(['index']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tag.index')->with(['tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Lưu dữ liệu của tag vào DB
        $request->validate([
            'name' => 'required',
            'style' => 'required',
        ]);

        $tag = new Tag([
            'name'=>$request['name'],
            'style'=>$request['style'],
        ]);

        // Lưu tag
        $tag->save();

        return $this->index()->with([
            'message_success' => 'The tag <b>' . $tag->name . '</b> was added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        // 87
        abort_unless(Gate::allows('update', $tag), 403);


        return view('tag.edit')->with([
            'tag'=>$tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // 87
        abort_unless(Gate::allows('update', $tag), 403);

        $request->validate([
            'name' => 'required',
            'style' => 'required',
        ]);

        $tag->update([
            'name'=>$request['name'],
            'style'=>$request['style'],
        ]);

        return $this->index()->with([
            'message_success' => 'The tag <b>' . $tag->name . '</b> was updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {

        // 87
        abort_unless(Gate::allows('delete', $tag), 403);

        // Lấy tên tag trước khi xóa
        $oldName = $tag->name;
        $tag->delete();

        // Chuyển hướng đến index và thông báo xóa thành công
        return $this->index()->with([
            'message_success' => 'The tag <b>' . $oldName . '</b> was deleted.'
        ]);
    }
}
