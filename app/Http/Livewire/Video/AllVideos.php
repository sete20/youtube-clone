<?php

namespace App\Http\Livewire\Video;


use App\Models\channel;
use App\Models\video;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
class AllVideos extends Component
{
    protected $listeners  = ['videoAdded' => '$refresh','someThingUpdated'=>'$refresh'];
    use WithPagination;
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    public $channel;
    public function mount(channel $channel){
        $this->channel=$channel;
    }
    public function render()
    {

        // dd($this->channel->videos()->thumbnail_image);
        $videos= video::whereChannelId($this->channel->id)->whereHas('thumbnail_image')->with(['thumbnail_image','channel'])->paginate(5);
        return view('livewire.video.all-videos')

        ->with('videos', $videos)
        ->extends('layouts.app');
    }
    public function delete(video $video){
        $this->authorize('delete',$video);
        $video->delete();
    }
    public function refreshCreateVideo($video){
        dd($video);
        session()->flash('message', 'new video uploaded successfully');

    }
}
