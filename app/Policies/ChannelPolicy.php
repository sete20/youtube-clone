<?php

namespace App\Policies;

use App\Models\channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;


    public function update(User $user, channel $channel)
    {


        return $user->id == $channel->user_id;
    }
}
