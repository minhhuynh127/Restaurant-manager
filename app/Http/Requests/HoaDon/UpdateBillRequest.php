<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBillRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                => 'required|exists:chi_tiet_ban_hangs,id',
            'so_luong_ban'      =>  'required|numeric',
            'tien_chiet_khau'   =>  'required|numeric',
            'ghi_chu'           =>  'nullable'
        ];
    }
    public function messages()
    {
        return [
            'id.*'                      =>  'Hóa đơn bán hàng không tồn tại',
            'so_luong_ban.*'            =>  'Số lượng bán không được dưới 0.1',
            'tien_chiet_khau.numeric'   =>  'Tiền chiết khấu phải là số',
            'ghi_chu.*'                 =>  'nullable'
        ];
    }
}
