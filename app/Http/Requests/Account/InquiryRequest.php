<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required',
            'comment' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'ステータスは必須項目です。',
            'comment.string' => 'コメントは文字列で指定してください。',
        ];
    }
}
