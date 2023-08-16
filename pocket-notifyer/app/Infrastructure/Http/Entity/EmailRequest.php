<?php

namespace App\Infrastructure\Http\Entity;

use App\Validations\Rule;

class EmailRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            "headers" => Rule::REQUIRED,
            "headers.subject" => Rule::REQUIRED,
            "headers.to" => Rule::REQUIRED,
            "body" => Rule::REQUIRED,
            "body.message" => Rule::REQUIRED,
        ];
    }
}
