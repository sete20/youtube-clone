<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function video(){
        return $this->belongsTo(video::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
