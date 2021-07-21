<?php

namespace App\Http\Livewire;

use App\Models\video;
use Livewire\Component;

class WatchVideo extends Component
{
    protected $listeners=['VideoViewed'=>'VideoViewed'];
    public $video;
    public function mount(video $video){
        $this->video=$video;
    }
    public function render()
    {
        return view('livewire.watch-video')->extends('layouts.app');
    }
    public function VideoViewed(){
        $this->video->update([
            'views' =>  $this->video->views + 1
        ]);
    }
}
