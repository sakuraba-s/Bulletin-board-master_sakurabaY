<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // バリデーションルール
    public function rules()
    {
        return [

            'name' => 'required|string|max:10',
            'email' => 'required|string|max:10',
            'password' => 'required|string|min:8|max:30|confirmed',
            //
        ];
    }

    // バリデーションメッセージ
    public function messages(){
        return [
            'name.max' => '※名前は10文字以下で入力してください。',
            'email' => '※メールアドレスの形式で入力してください。',
            'email.max' => '※メールアドレスは100文字以内で入力してください。',
            'email.unique' => '※登録済みのメールアドレスです。',
            'password.min' => '※パスワードは8文字以上で入力してください。',
            'password.max' => '※パスワードは30文字以下で入力してください。',
            'password.confirmed' => '※パスワードが一致しません。',

        ];
    }
}
