<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    // 42. Kết nối các Models với Eloquent Relationship
    // Một hobby chỉ thuộc về một user (chiều từ bảng hobbies đến users)
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    // 42. Kết nối các Models với Eloquent Relationship
    // Quan hệ nhiều nhiều (hobbies-tags)
    // Một hobby có nhiều tags
    public function tags(){
        return $this->belongsToMany(\App\Models\Tag::class);
    }



    // Chỉ cho phép các trường được chỉ định ở đây được phép ghi vào dữ liệu
    protected $fillable = [
        'name',
        'description',
    ];


}
