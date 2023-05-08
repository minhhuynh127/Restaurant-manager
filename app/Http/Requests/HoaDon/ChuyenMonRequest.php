<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class ChuyenMonRequest extends FormRequest
{

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
            'id_hoa_don_nhan' => 'required|exists:hoa_don_ban_hangs,id'
        ];
    }
    public function messages()
    {
        return [
            'id_hoa_don_nhan.*' => 'Vui lòng chọn bàn!'
        ];
    }
}
