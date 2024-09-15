<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => 'required',
            'product_price' => 'required|integer|between:0,10000',
            'product_image' => 'required|mimes:png,jpeg',
            'product_season' => 'required',
            'product_description' => 'required|max:120'
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください',
            'product_price.required' => '値段を入力してください',
            'product_price.integer' => '数値で入力してください',
            'product_price.between:0,10000' => '0~10000円以内で入力してください',
            'product_image.required' => '商品画像を登録してください',
            'product_image.mimes:png,jpeg' => '「.png」または「.jpeg」形式でアップロードしてください',
            'product_season.required' => '季節を選択してください',
            'product_description.required' => '商品説明を入力してください',
            'product_description.max:120' => '120文字以内で入力してください',
        ];
    }
}
