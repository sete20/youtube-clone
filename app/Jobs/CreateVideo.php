<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        FFMpeg::fromDisk('channel_uploads')
        ->open($this->video->channel->user->id.'/channel_media/videos/'.$this->video->id.'/'.$this->video->path)
        ->getFrameFromSeconds(2)
        ->export()
        ->toDisk('channel_uploads')
        ->save($this->video->channel->user->id.'/channel_media/videos/'.$this->video->id.'/video_cover/'.$this->video->uid . '.png');
        $this->video->load('thumbnail_image');
        $this->video->thumbnail_image()->create([
            'name' => $this->video->uid . '.png',
            'type'=>'photo'
        ]);
    }
}
