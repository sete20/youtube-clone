<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required| string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'channelCover'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'channelName'=>'required|string|unique:channels,name',
            'channelDescription'=>'nullable|string'
        ];
    }
}
