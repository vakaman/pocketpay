<?php

namespace App\Infrastructure\Http\Entity\Transaction;

use App\Validations\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from_wallet' => [
                Rule::REQUIRED,
                Rule::UUID
            ],
            'to_wallet' => [
                Rule::REQUIRED,
                Rule::UUID
            ],
            'value' => [
                Rule::REQUIRED,
                Rule::INTEGER,
                Rule::UNSIGNED,
                Rule::min(1)
            ]
        ];
    }
}
