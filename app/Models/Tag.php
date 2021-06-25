<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'style',
    ];

    // 42. Kết nối các Models với Eloquent Relationship
    // Quan hệ nhiều nhiều (hobbies-tags)
    // Một tag có thể thuộc về nhiều hobbies
    public function hobbies(){
        return $this->belongsToMany(\App\Models\Hobby::class);
    }

    // 53
    public function filteredHobbies(){
        return $this->belongsToMany(\App\Models\Hobby::class)
            ->wherePivot('tag_id', $this->id)
            ->orderBy('updated_at', 'DESC');
    }


}
