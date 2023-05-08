<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateKhuVucRequest extends FormRequest
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
            'ten_khu'       => 'required|min:5|max:30',
            'slug_khu'      =>  'required|min:5|unique:khu_vucs,slug_khu',
            'tinh_trang'    =>  'required|boolean'
        ];
    }
    public function messages()
    {
        return  [
            'ten_khu.required'      =>  'Yêu cầu tên khu không được bỏ trống',
            'ten_khu.min'           =>  'Tên khu ít nhất 5 ký tự',
            'ten_khu.max'           =>  'Tên khu không được quá 30 ký tự',
            'slug_khu.required'     =>  'Yêu cầu slug khu không đưuọc bỏ trống',
            'slug_khu.unique'       =>  'Slug khu đã tồn tại trong hệ thống',
            'tinh_trang.*'          =>  'Vui lòng chọn tình trạng',
        ];
    }
}
