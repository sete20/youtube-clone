<?php

namespace App\Http\Controllers\Auth;
use Ramsey\Uuid\Uuid;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\registerRequest;
use App\Models\channel;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return view('auth.register');
    }
    protected function create(registerRequest $r)
    {
        $r->validated();
        $user = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
        ]);
        $type="personal_images";
        uploadMedia($user,$r->file('image'),$type);
        $user->channel()->create([
            'name'=>$r->channelName,
            'description'=>$r->channelDescription,
            'uid'=> uniqid(true),
            'slug'=>Str::slug($r->channelName,'-')
        ]);
        Auth::login($user);
        $type="channel_media";
        $channel=channel::whereUserId($user->id)->first();
        uploadChannelMedia($channel,$r->file('channelCover'),$type);
        return redirect()->route('home');
}

}
