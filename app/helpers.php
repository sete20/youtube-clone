<?php
if (!function_exists('uploadMedia')){
     function uploadMedia($media,$r,$type){
        if ($media->channelCover && $type=="update") {
            $location = public_path('/media/users/'.$media->id.'/personal_image/'.$media->image->name);
                unlink($location);
           }
           $r->storePubliclyAs($media->id.'/personal_image',$r->getClientOriginalName(),'channel_uploads');
            $media->image()->updateOrCreate([
                'name'=>$r->getClientOriginalName(),
                'type'=>'photo'
            ]);
    }
}





if (!function_exists('uploadChannelMedia')){
    function uploadChannelMedia($media,$r,$type){
       if ($media->channelCover && $type=="update") {
        $location = public_path('media/users/'.$media->user->id.'/channel_media/'.$media->channelCover->name);
            unlink($location);
       }
           $r->storePubliclyAs($media->user->id.'/channel_media/cover/',$r->getClientOriginalName(),'channel_uploads');
           if($type=="update"){
            $media->channelCover()->update([
                'name'=>$r->getClientOriginalName(),
                'type'=>"photo"
            ]);
           }else{
           $media->channelCover()->Create([
               'name'=>$r->getClientOriginalName(),
               'type'=>"photo"
            ]);
        }
        }
        if(!function_exists('saveVideo')){
            function saveVideo($model, $file,$type=null){
                if ($model->channel && $type=="update") {
                    $location= public_path('/media/users/'.$model->channel->user->id.'/channel_media/videos/'.$model->id.'/'.$model->path);
                        unlink($location);
                   }else{

                    $file->storePubliclyAs($model->channel->user->id.'/channel_media/videos/'.$model->id,$file->getClientOriginalName(),'channel_uploads');

                    $model->update(['path'=>$file->getClientOriginalName()]);

                   }
            }
        }
}



