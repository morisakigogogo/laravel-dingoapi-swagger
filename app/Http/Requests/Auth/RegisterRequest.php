<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:16',
            'email' => 'required|email|unique:users', // unique 唯ー　ユーザテーブルを検証する
            'password' => 'required|min:6|max:16|confirmed',
        ];
    }

    // resources/lang/ja オーバライト検証メッセージ
    public function messages()
    {
        return [ // 検証カラム　＋　検証規則
            'name.required' => 'お名前は必ず入力して下さい。',
            'name.max' => 'お名前は最大16文字に入力して下さい。',
            'password.min' => 'パスワードは6文字以上にして下さい。'
        ];
    }
}
