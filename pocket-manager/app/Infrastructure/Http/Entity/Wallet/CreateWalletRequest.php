<?php

namespace App\Infrastructure\Http\Entity\Wallet;

use App\Infrastructure\Request\FormRequest;
use App\Validations\Rule;

class CreateWalletRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person' => [
                Rule::REQUIRED,
                Rule::UUID
            ]
        ];
    }
}
