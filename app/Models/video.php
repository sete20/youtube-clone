<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    use HasFactory;

    protected $guarded=[];

 public function channel(){
     return $this->belongsTo(channel::class);
 }
 public function thumbnail_image(){
    return $this->morphOne(photo::class,'photoable');
}
public function likes(){
    return $this->hasMany(like::class);
}
public function dislikes(){
    return $this->hasMany(dislike::class);
}
    function isLiked(){
        return $this->likes()->where('user_id',auth()->id())->exists();
    }
    function isDisliked(){
        return $this->dislikes()->where('user_id',auth()->id())->exists();
    }
}
