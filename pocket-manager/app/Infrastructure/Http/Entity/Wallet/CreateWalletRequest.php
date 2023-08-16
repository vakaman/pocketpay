<?php

namespace App\Infrastructure\Http\Entity\Wallet;

use App\Validations\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateWalletRequest extends FormRequest
{
    public function rule(): array
    {
        return [
            'person' => [
                Rule::required,
                Rule::uuid
            ]
        ];
    }
}
