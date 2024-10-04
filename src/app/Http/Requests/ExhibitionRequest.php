<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image' => "required|mimes:jpeg,png",
            'categories' => "required|array|min:1",
            'condition' => "required",
            'name' => "required",
            'content' => "required|max:255",
            'price' => "required|numeric|min:0"
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'プロフィール画像をアップロードしてください',
            'image.mimes' => 'プロフィール画像はjpegもしくはpngのデータをアップロードしてください',
            'categories.required' => 'カテゴリーを選択してください',
            'categories.min' => 'カテゴリーを選択してください',
            'categories.array' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'content.required' => '商品の説明を入力してください',
            'content.max' => '商品の説明は255文字以下で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数値型で入力してください',
            'price.min' => '販売価格は0円以上で入力してください'
        ];
    }
}
