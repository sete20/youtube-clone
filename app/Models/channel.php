<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class channel extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function returnRouteKeyName(){
        return 'slug';
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function channelCover(){
        return $this->morphOne(photo::class,'photoable');
    }
    public function videos(){
        return $this->hasMany(video::class);
    }
}
