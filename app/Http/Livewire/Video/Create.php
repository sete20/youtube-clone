<?php

namespace App\Http\Livewire\Video;

use App\Jobs\ConvertVideo;
use App\Jobs\CreateVideo;
use App\Models\{channel,video,User};
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public channel $channel;
    public video $video;
    public $videoFile;

    protected $rules = [
        'videoFile' => 'required|mimes:mp4|max:1228800'
    ];
    public function mount(channel $channel){
        $this->channel= $channel;
        $this->channel->load('videos');
    }
    protected $messages = [
        'videoFile.required' => 'The Input could not be empty.',
        'videoFile.mimes' => 'The format is not valid.',
        'videoFile.max' =>'please change the video file with another lower size'
    ];
    public function render()
    {
        return view('livewire.video.create')
        ->extends('layouts.app');
    }
    // public function  upload(){
    //     $this->validate([
    //     'videoFile'=>'required|mimes:mp4|max:102400'
    //     ]);
    // }
    public function fileCompleted(){
        $this->validate();

       $newVideo= $this->video = $this->channel->videos()->create([
            'title'=>'untitled',
            'description'=>'none',
            'visibility'=>'private',
            'uid'=>uniqid(true),
        ]);
        saveVideo($this->video,$this->videoFile);

        CreateVideo::dispatch($this->video);
        ConvertVideo::dispatch($this->video);
        $this->emit('videoAdded');
        return redirect()->route('video.edit',['channel'=>$this->channel->id,'video'=>$this->video->id]);
    }
}
