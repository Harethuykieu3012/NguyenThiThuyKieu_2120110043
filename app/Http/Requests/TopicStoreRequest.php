<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:2',
            'metakey' => 'required',
            'metadesc' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Bạn chưa nhập tên',
            'title.min' => 'Tên ít nhất 2 kí tự',
            'metakey.required' => 'Bạn chưa nhập từ khóa tìm kiếm',
            'metadesc' => 'Bạn chưa nhập mô tả'
        ];
    }
}
