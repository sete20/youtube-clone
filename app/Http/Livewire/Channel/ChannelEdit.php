<?php

namespace App\Http\Livewire\Channel;

use Livewire\Component;
use App\Models\channel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithFileUploads;
use Image;
use File;

use Illuminate\Http\Request;

class ChannelEdit extends Component
{
use AuthorizesRequests,WithFileUploads;
    public $channel;
    public $image ;
    public function mount(channel $channel){
        $this->channel = $channel;
        // dd($channel);
        // if($image != null ) dd($image);
    }
    public function render()
    {
        return view('livewire.channel.channel-edit');
    }
    protected function rules()
    {

        return [

            'channel.name' => 'required|max:255|unique:channels,name,' . $this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' . $this->channel->id,
            'channel.description' => 'nullable|max:1000',
            'image' => 'nullable|image|max:1024',

        ];
    }
    public function update()
    {
        $this->validate();
        $this->authorize('update',$this->channel);
        $this->channel->update([

            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,

        ]);
        if ($this->image) {
            $img = uploadChannelMedia($this->channel,$this->image,$type="update");

        }
        session()->flash('message', 'Channel updated');
        return redirect()->route('channel.edit', ['channel' => $this->channel->id]);
    }
}
