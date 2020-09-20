<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntryRequest extends FormRequest
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
            'datetime' => ['required'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required'],
            'categories' => ['required'],
            'user_id' => ['required', 'integer'],
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'datetime' => '日時',
            'title' => 'タイトル',
            'body' => '本文',
            'categories' => 'カテゴリ',
            'user_id' => 'ユーザ',
        ];
    }
}
