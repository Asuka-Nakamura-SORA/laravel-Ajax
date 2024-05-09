<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'body' => ['required', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required'  => 'コメントは必須項目だよん。',
            'body.max'       => 'コメントは50文字以下で入力してねん。',
        ];
    }
}