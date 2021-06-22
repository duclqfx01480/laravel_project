<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    // Chỉ cho phép các trường được chỉ định ở đây được phép ghi vào dữ liệu
    protected $fillable = [
        'name',
        'description',
    ];


}
