<?php

namespace App\Http\Livewire\Video;

use App\Models\channel;
use App\Models\video;
use Livewire\Component;

class Edit extends Component
{
    public channel $channel;
    public video $video;
    public function mount(channel $channel,video $video){
    $this->channel = $channel;
    $this->video = $video;
    }
    protected $rules = [
        'video.title' => 'required|max:255',
        'video.description' => 'nullable|max:1000',
        'video.visibility' => 'required|in:private,public',
    ];
    public function render()
    {
        return view('livewire.video.edit')->extends('layouts.app');
    }
    public function update()
    {
        $this->validate();
        //update video record
        $this->video->update([
            'title' => $this->video->title,
            'description' => $this->video->description,
            'visibility' => $this->video->visibility
        ]);
        $this->emit('someThingUpdated');
        session()->flash('message', 'video was update ');
    }
}
