<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'des' ,
        'meta_des' ,
        'meta_keywords' ,
        'youtube' ,
        'cat_id' ,
        'user_id' ,
        'published',
        'image'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function cat(){
        return $this->belongsTo(Category::class,'cat_id');
    }
}
