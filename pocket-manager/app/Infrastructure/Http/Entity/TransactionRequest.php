<?php

namespace App\Infrastructure\Http\Entity;

use App\Validations\Rule;

class TransactionRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "headers" => Rule::required,
            "headers.subject" => Rule::required,
            "headers.to" => Rule::required,
            "body" => Rule::required,
            "body.message" => Rule::required,
        ];
    }
}
