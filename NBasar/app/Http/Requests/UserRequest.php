<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'string',
            'email' => 'string',
            'password' => 'string',
            'surname' => 'string',
            'uuid' => 'string',
            'data' => '',
            'seller_id' => 'integer',
            'seller_email' => 'string',
            'estate_uuid' => 'string',
        ];
    }


    public function messages(): array
    {
        return [
            'name.string' => 'Name is not valid',
            'email.string' => 'Email is not valid',
            'password.string' => 'Password is not valid',
        ];
    }
}
