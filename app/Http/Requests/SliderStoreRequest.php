<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'image' => 'required',
            'link' => 'required'


        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'name.min' => 'Tên ít nhất 2 kí tự',
            'link.required' => 'Bạn chưa nhập link',
            'image' => 'Bạn chưa chọn hình ảnh'
        ];
    }
}
