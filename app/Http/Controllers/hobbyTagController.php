<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Hobby;
use Illuminate\Support\Facades\Gate;

class hobbyTagController extends Controller
{
    // Viết hàm để hiển thị hobbies theo một tag nào đó
    public function getFilteredHobbies($tag_id){
        // Lấy ra một instance của Tag
        $tag = new Tag();

        // Cho tag tìm một tag_id nào đó, rồi gọi phương thức lọc hobbies & phân trang
        $hobbies = $tag::findOrFail($tag_id)->filteredHobbies()->paginate(10);

        // Truyền dữ liệu của tag đang lọc qua cho view => hiển thị lên thanh tiêu đề ("Đang lọc cho...")
        // Ở đây không cần dùng findOrFail, vì dòng trên nếu fail thì không thể đến dòng này được
        $filter = $tag::find($tag_id);

        // truyền hobbies vừa lọc được qua view hobby/index.blade.php
//        return view('hobby.index')->with([
//            'hobbies'=>$hobbies
//        ]);

        return view('hobby.index', [
            'hobbies'=>$hobbies,
            'filter' => $filter
        ]); // truyền dữ liệu ở tham số thứ hai, hoặc dùng with như ở trên
    }

    // 55
    public function attachTag($hobby_id, $tag_id){
        $hobby = Hobby::find($hobby_id);

        // 89. Trước khi lấy ra tag cần gắn thì cần kiểm tra (với Gate)
        if(Gate::denies('connect_hobbyTag', $hobby)){
            abort(403, 'Oh no! This hobby is not yours!');
        }

        // Lấy tag ra để thông báo gắn tag nào thành công
        $tag = Tag::find($tag_id);

        // tags là relationship đã tạo trong Hobby model
        $hobby->tags()->attach($tag_id);

        return back()->with([
            'message_success' => 'The Tag <b>' . $tag->name . '</b> was added.'
        ]);

    }

    public function detachTag($hobby_id, $tag_id){
        $hobby = Hobby::find($hobby_id);

        // 89
        if(Gate::denies('connect_hobbyTag', $hobby)){
            abort(403, 'Oh no! This hobby is not yours!');
        }

        $tag = Tag::find($tag_id);

        $hobby->tags()->detach($tag_id);

        return back()->with([
            'message_success' => 'The Tag <b>' . $tag->name . '</b> was removed.'
        ]);

    }




}
