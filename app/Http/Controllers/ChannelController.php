<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\channel;
class ChannelController extends Controller
{
    public function edit(channel $channel)
    {
        if ($channel->user_id == auth()->id()) {
            return view('channel.edit', compact('channel'));
        }
        elseif($channel->user_id != auth()->id()){
            $channel=channel::whereUserId(auth()->id());
            return view('channel.edit', compact('channel'));
        }
    }
}
