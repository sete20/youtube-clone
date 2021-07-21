<?php

namespace App\Jobs;
use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideo implements ShouldQueue
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
        $current_path= $this->video->channel->user->id.'/channel_media/videos/'.$this->video->id.'/'.$this->video->path;
        $lowBitrate = (new X264('aac'))->setKiloBitrate(100);
        $midBitrate = (new X264('aac'))->setKiloBitrate(250);
        $highBitrate = (new X264('aac'))->setKiloBitrate(500);
        FFMpeg::fromDisk('channel_uploads')
        ->open($current_path)
        ->exportForHLS()
        ->addFormat($lowBitrate)
        ->addFormat($midBitrate)
        ->addFormat($highBitrate)

        ->onProgress(function($progress){
            $this->video->update([
                'processing_percentage' => $progress
            ]);
        })
        ->toDisk('channel_uploads')
        ->save($this->video->channel->user->id.'/channel_media/videos/'.$this->video->id.'/qualities/' .$this->video->uid . '.m3u8');

        $this->video->update([
            'processed' => true,
            'path'=>$this->video->channel->user->id.'/channel_media/videos/'.$this->video->id.'/qualities/' .$this->video->uid . '.m3u8',
            'processed_file' => $this->video->uid . '.m3u8'
        ]);
        unlink(public_path('/media/users/'.$current_path));
        Log::info($this->video->path . ' video was deleted from videos-temp folder');

    }
}
