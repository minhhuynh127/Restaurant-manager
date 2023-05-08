<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuyenRequest extends FormRequest
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
            'ten_quyen'     => 'required|unique:quyens,ten_quyen,' .$this->id,
            'list_id_quyen' =>'required',
        ];
    }

    public function messages()
    {
        return [
            'ten_quyen.required'    => 'Tên quyền không được để trống!',
            'ten_quyen.unique'      => 'Tên quyền đã tồn tại trên hệ thống!',
            'list_id_quyen.*'       =>  'List id quyền không được trống!'
        ];
    }
}
