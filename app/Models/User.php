<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function channel(){
        return $this->hasOne(channel::class);
    }
    public function image(){
        return $this->morphOne(photo::class,'photoable');
    }
    public function owns(video $video){
        return $this->id == $video->channel->user_id;
    }
    public function likes(){
        return $this->hasMany(like::class);
    }
    public function dislike(){
        return $this->hasMany(dislike::class);
    }
}

