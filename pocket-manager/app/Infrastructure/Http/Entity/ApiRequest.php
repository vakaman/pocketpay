<?php

namespace App\Infrastructure\Http\Entity;

use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{

    public function authorize(): bool
    {
        if ($this->isMethod('GET')) {
            return true;
        }

        return $this->isJson();
    }
}
