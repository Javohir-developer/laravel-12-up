<?php

namespace Modules\Api\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class CardCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'card_number' => ['required', 'string', 'min:16', 'max:16'],
            'expire'      => ['required', 'string', 'size:4'],  // "0399"
        ];
    }
}
