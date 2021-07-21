<?php

namespace App\Observers;
use Illuminate\Filesystem\Filesystem;
use App\Models\video;

class videoObserver
{
    /**
     * Handle the video "created" event.
     *
     * @param  \App\Models\video  $video
     * @return void
     */
    public function created(video $video)
    {
        //
    }

    /**
     * Handle the video "updated" event.
     *
     * @param  \App\Models\video  $video
     * @return void
     */
    public function updated(video $video)
    {
        //
    }

    /**
     * Handle the video "deleted" event.
     *
     * @param  \App\Models\video  $video
     * @return void
     */
    public function deleted(video $video)
    {
        \File::deleteDirectory(public_path('media/users/'.$video->channel->user->id.'/channel_media/videos/'.$video->id));

    }


    public function restored(video $video)
    {
        //
    }

    public function forceDeleted(video $video)
    {
        //
    }
}
