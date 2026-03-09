<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class CardVerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'card_id' => ['required', 'integer', 'exists:cards,id'],
            'token'   => ['required', 'string'],
            'code'    => ['required', 'string', 'size:6'],  // SMS kod
        ];
    }
}
