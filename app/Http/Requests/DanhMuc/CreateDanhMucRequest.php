<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateDanhMucRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ten_danh_muc'  =>  'required|min:5|max:30',
            'slug_danh_muc' =>  'required|min:5|unique:danh_mucs,slug_danh_muc',
            'tinh_trang'    =>  'required|boolean'
        ];
    }

    public function messages()
    {
        return  [
            'ten_danh_muc.required'     =>  'Tên danh mục không được để trống',
            'ten_danh_muc.min'          =>  'Tên danh mục không ít hơn 5 ký tự',
            'ten_danh_muc.max'          =>  'Tên danh mục không quá 30 ký tự',
            'slug_danh_muc.required'    =>  'Slug danh mục không được để trống',
            'slug_danh_muc.min'         =>  'Slug danh mục không ít hơn 5 ký tự',
            'slug_danh_muc.unique'      =>  'Slug danh mục đã tồn tại',
            'tinh_trang.*'              =>  'Vui lòng chọn tình trạng theo yêu cầu'
        ];
    }
}
