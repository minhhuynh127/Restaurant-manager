<?php

namespace App\Http\Requests\MonAn;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonAnRequest extends FormRequest
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
            'id'            =>  'required|exists:mon_ans,id',
            'ten_mon'       =>  'required|min:5|max:30',
            'slug_mon'      =>  'required|min:5|unique:mon_ans,slug_mon,' . $this->id,
            'gia_ban'       =>  'required|numeric|min:0',
            'tinh_trang'    =>  'required|boolean',
            'id_danh_muc'   =>  'required|exists:danh_mucs,id'
        ];
    }
    public function messages()
    {
        return [
            'id.*'              =>  'Món ăn không tồn tại',
            'ten_mon.required'  =>  'Yêu cầu phải nhập tên món',
            'ten_mon.min'       =>  'Tên món phải từ 5 ký tự',
            'ten_min.max'       =>  'Tên món tối đa được 30 ký tự',
            'slug_mon.*'        =>  'Slug món đã tồn tại',
            'gia_ban.required'  =>  'Yêu cầu phải nhập giá bán',
            'gia_ban.numeric'   =>  'Giá bán phải là số',
            'gia_ban.min'       =>  'Giá bán ít nhất là 0$',
            'tinh_trang.*'      =>  'Vui lòng chọn tình trạng theo yêu cầu',
            'id_danh_muc.*'     =>  'Danh mục không tồn tại trong hệ thống',
        ];
    }
}
