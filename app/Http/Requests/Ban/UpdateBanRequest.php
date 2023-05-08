<?php

namespace App\Http\Requests\Ban;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBanRequest extends FormRequest
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
            'id'            =>  'required|exists:bans,id',
            'ten_ban'       =>  'required|min:5|max:20',
            'slug_ban'      =>  'required|min:5|unique:bans,slug_ban,' . $this->id,
            'id_khu_vuc'    =>  'required|exists:khu_vucs,id',
            'gia_mo_ban'    =>  'required|numeric|min:0',
            'tien_gio'      =>  'required|numeric|min:0',
            'tinh_trang'    =>  'required|boolean'
        ];
    }

    public function messages()
    {
        return  [
            'id.*'                  =>  'Bàn không có trong hệ thống',
            'ten_ban.required'      =>  'Yêu cầu tên bàn không được để trống',
            'ten_ban.min'           =>  'Tên bàn ít nhất 5 ký tự',
            'ten_ban.max'           =>  'Tên bàn không được quá 20 ký tự',
            'slug_ban.required'     =>  'Yêu cầu slug bàn không được để trống',
            'slug_ban.unique'       =>  'Slug bàn đã tồn tại trong hệ thống',
            'id_khu_vuc.*'          =>  'Vui lòng chọn khu vực theo yêu cầu',
            'gia_mo_ban.required'   =>  'Yêu cầu tiền giá mở bán không được để trống',
            'gia_mo_ban.numeric'    =>  'Yêu cầu giá mở bán phải là số',
            'gia_mo_ban.min'        =>  'Giá mở bán không được nhỏ hơn 0 đồng',
            'tien_gio.required'     =>  'Yêu cầu tiền tiền giờ không được để trống',
            'tien_gio.numeric'      =>  'Yêu cầu tiền giờ phải là số',
            'tien_gio.min'          =>  'Tiền giờ không được nhỏ hơn 0 đồng',
            'tinh_trang.*'          =>  'Vui lòng chọn tình trạng theo yêu cầu',
        ];
    }
}
