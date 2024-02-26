<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $uniqueRule = Rule::unique('accounts')->ignore($this->route('user'));

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $this->isMethod('put') || $this->isMethod('post') ? $uniqueRule : '',
            ],
            
            'password' => $this->isMethod('put') ? 'nullable|string|min:8' : 'required|confirmed|min:8',
            'sub_name' => 'required|string|max:255',
            'tel' => 'required|regex:/^[0-9]{3}[0-9]{4}[0-9]{4}$/',
            'post_code' => 'required|regex:/^[0-9]{3}[0-9]{4}$/',
            'prefecture' => 'required',
            'city' => 'required|string',
            'street' => 'required|string',
            'admin_level' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は必須項目です。',
            'name.string' => '名前は文字列で入力してください。',
            'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'email.unique' => '指定されたメールアドレスは既に使用されています。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'password.nullable' => 'パスワードは文字列で入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'sub_name.required' => 'フリガナは必須項目です。',
            'sub_name.string' => 'フリガナは文字列で入力してください。',
            'sub_name.max' => 'フリガナは255文字以内で入力してください。',
            'tel.required' => '電話番号は必須項目です。',
            'tel.regex' => '電話番号の形式が正しくありません。',
            'post_code.required' => '郵便番号は必須項目です。',
            'post_code.regex' => '郵便番号の形式が正しくありません。',
            'prefecture.required' => '都道府県は必須項目です。',
            'city.required' => '市区町村は必須項目です。',
            'city.string' => '市区町村は文字列で入力してください。',
            'street.required' => '番地は必須項目です。',
            'street.string' => '番地は文字列で入力してください。',
            'admin_level.required' => '管理者レベルは必須項目です。',
        ];
    }
}
