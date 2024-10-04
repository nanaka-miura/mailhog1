<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'image' => "mimes:jpeg,png",
            'name' => "required",
            'postal_code' => "required|regex:/^\d{3}-\d{4}$/",
            'address' => "required"
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => 'プロフィール画像はjpegもしくはpngのデータをアップロードしてください',
            'name' => 'お名前を入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンを含めて8桁で入力してください',
            'address.required' => '住所を入力してください'
        ];
    }
}
