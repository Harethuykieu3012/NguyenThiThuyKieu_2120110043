<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'detail' => 'required',
            'metakey' => 'required',
            'metadesc' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price_buy' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'detail.required' => 'Bạn chưa nhập chi tiết',
            'metakey.required' => 'Bạn chưa nhập từ khóa tìm kiếm',
            'metadesc' => 'Bạn chưa nhập mô tả',
            'category_id' => 'Bạn chưa danh mục',
            'brand_id' => 'Bạn chưa chọn thương hiệu',
            'price_buy' => 'Bạn chưa nhập giá'
        ];
    }
}
