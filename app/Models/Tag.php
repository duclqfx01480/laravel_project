<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // 42. Kết nối các Models với Eloquent Relationship
    // Quan hệ nhiều nhiều (hobbies-tags)
    // Một tag có thể thuộc về nhiều hobbies
    public function hobbies(){
        return $this->belongsToMany(\App\Models\Hobby::class);
    }

    protected $fillable = [
        'name',
        'style',
    ];
}
