<?php

namespace App\Infrastructure\Request;

use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class FormRequest extends HttpFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator));
    }
}
