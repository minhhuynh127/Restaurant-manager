<?php

namespace App\Http\Requests\NhaCungCap;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNhaCungCapRequest extends FormRequest
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
            'id'                    =>  'required|exists:nha_cung_caps,id',
            'ma_so_thue'            =>  'required|min:2|max:20|unique:nha_cung_caps,ma_so_thue,' . $this->id,
            'ten_cong_ty'           =>  'required|min:5|max:30',
            'ten_nguoi_dai_dien'    =>  'required|min:2|max:50',
            'so_dien_thoai'         =>  'required|numeric',
            'email'                 =>  'required|email',
            'dia_chi'               =>  'required',
            'ten_goi_nho'           =>  'required|min:2|max:30',
            'tinh_trang'            =>  'required|boolean',
        ];
    }

    public function messages()
    {
        return  [
            'ma_so_thue.required'           =>  'Vui lòng nhập mã số thuê',
            'ma_so_thue.min'                =>  'Mã số thuế không ít hơn 2 ký tự',
            'ma_so_thue.max'                =>  'Mã số thuế không quá 20 ký tự',
            'ma_so_thue.unique'             =>  'Mã số thuế đã tồn tại',
            'ten_nguoi_dai_dien.required'   =>  'Vui lòng nhập tên người đại diện',
            'ten_nguoi_dai_dien.min'        =>  'Tên người đại diện không ít hơn 5 ký tự',
            'ten_nguoi_dai_dien.max'        =>  'Tên người đại diện không quá 50 ký tự',
            'so_dien_thoai.required'        =>  'Số điện thoại không được để trống',
            'so_dien_thoai.numeric'         =>  'Số điên thoại chưa đúng định dạng',
            'email.required'                =>  'Email không được để trống',
            'email.email'                   =>  'Email chưa đúng định dạng',
            'dia_chi.required'              =>  'Vui lòng nhập địa chỉ',
            'ten_goi_nho.required'          =>  'Vui lòng nhập tên gợi nhớ',
            'ten_goi_nho.min'               =>  'Tên gợi nhớ không ít hơn 2 ký tự',
            'ten_goi_nho.max'               =>  'Tên gợi nhớ không quá 30 ký tự',
            'tinh_trang.*'                  =>  'Vui lòng chọn tình trạng'
        ];
    }
}
