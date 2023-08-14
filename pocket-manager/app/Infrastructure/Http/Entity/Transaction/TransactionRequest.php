<?php

namespace App\Infrastructure\Http\Entity\Transaction;

use App\Validations\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rule(): array
    {
        return [
            'from_wallet' => [
                Rule::required,
                Rule::uuid
            ],
            'to_wallet' => [
                Rule::required,
                Rule::uuid
            ],
            'value' => [
                Rule::required,
                Rule::integer,
                Rule::unsigned,
                Rule::min(1)
            ]
        ];
    }
}
