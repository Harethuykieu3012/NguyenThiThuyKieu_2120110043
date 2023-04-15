<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'metakey' => 'required',
            'metadesc' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'name.min' => 'Tên ít nhất 2 kí tự',
            'metakey.required' => 'Bạn chưa nhập từ khóa tìm kiếm',
            'metadesc' => 'Bạn chưa nhập mô tả'
        ];
    }
}
