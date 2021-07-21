<?php

namespace App\Http\Livewire\Video;

use App\Models\dislike;
use App\Models\like;
use App\Models\video;
use Livewire\Component;

class Voting extends Component
{
    public $video;
    public $likes;
    public $dislikes;
    public $likeActive;
    public $dislikeActive;
    protected $listeners = ['load_values' => '$refresh'];
    public function mount(video $video){
        $this->video =$video;
        $this->checkIfLiked();
        $this->checkIfDisliked();
    }
    public function checkIfLiked(){
        $this->video->isLiked() ?  $this->likeActive = true : $this->likeActive = false;
    }
    public function checkIfDisliked(){
        $this->video->isDisliked() ?  $this->dislikeActive = true : $this->dislikeActive = false;

    }
    public function render()
    {
        return view('livewire.video.voting')->extends('layouts.app');
    }
    public function like(){
        if($this->video->isLiked()){
            like::where('user_id',auth()->id())->where('video_id', $this->video->id)->delete();
        }
        else {
            $this->video->likes()->create([
                'user_id' => auth()->id()
            ]);
            $this->disableDislike();
            $this->likeActive = true;
        }
            $this->emit('load_values');

    }
    public function dislike(){
        if($this->video->isDisliked()){
            dislike::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
            $this->dislikeActive = false;

        }else {
        $this->video->dislikes()->create([
            'user_id' => auth()->id()
        ]);
        $this->disableLike();
        $this->dislikeActive = true;
    }
    $this->emit('load_values');
}

public function disableDislike()
{
    Dislike::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
    $this->dislikeActive = false;
}

public function disableLike()
{
    Like::where('user_id', auth()->id())->where('video_id', $this->video->id)->delete();
    $this->likeActive = false;
}
}
