<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Config;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company' => 'required|max:20',
            'name' => 'required',
            'tel' => 'required|regex:/^[0-9]{3}[0-9]{4}[0-9]{4}$/',
            'email' => 'required|email',
            'birthday' => 'required',
            'gender' => 'required',
            'profession' => 'required',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'company.required' => '会社名は必須項目です。',
            'company.max' => '会社名は20文字以内で入力してください。',
            'name.required' => '氏名は必須項目です。',
            'tel.required' => '電話番号は必須項目です。',
            'tel.regex' => '電話番号の形式が正しくありません。',
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'birthday.required' => '生年月日は必須項目です。',
            'gender.required' => '性別は必須項目です。',
            'profession.required' => '職業は必須項目です。',
            'body.required' => 'お問い合わせ内容は必須項目です。',
        ];
    }
}
