<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

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
}
