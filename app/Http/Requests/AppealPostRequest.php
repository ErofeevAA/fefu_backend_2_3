<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppealPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'surname' => ['required','string','max:40'],
            'name' => ['required','string','max:20'],
            'patronymic' => ['nullable','string','max:20'],
            'age' => ['required','integer','between:14, 125'],
            'gender' => ['required', Rule::in([Gender::MALE, Gender::FEMALE])],
            'phone' => ['required_if:email,null','nullable','string','regex: /^((\+7)|7|8){1} \(\d{3}\) \d{2}-\d{2}-\d{3}$/'],
            'email' => ['required_if:phone,null','nullable','string','max:100', 'regex:/^[\w\.-]+@\w+\.\w+\b$/'],
            'message' => ['required','string','max:100'],
        ];
    }
}
