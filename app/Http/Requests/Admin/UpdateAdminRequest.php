<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'id'                =>  'required|exists:admins,id',
            'email'             =>  'required|unique:admins,email,' . $this->id,
            'ho_va_ten'         =>  'required|min:5',
            'so_dien_thoai'     =>  'required|digits:10',
            'ngay_sinh'         =>  'required|date',
        ];
    }
    public function messages()
    {
        return [
            'id.*'                =>  'Nhà cung cấp không tồn tại!',
            'email.required'      =>  'Email không được để trống!',
            'email.unique'        =>  'Email đã tồn tại trên hệ thống!',
            'ho_va_ten.*'         =>  'Họ và tên không được để trống!',
            'so_dien_thoai.*'     =>  'Số điện thoại phải là 10 số!',
            'ngay_sinh.*'         =>  'Ngày sinh không được để trống!',
        ];
    }
}
