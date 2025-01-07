<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PushSubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subscription' => [
                'required',
                'array',
            ],
            'subscription.endpoint' => [
                'required',
                'url',
            ],
            'subscription.keys' => [
                'required',
                'array',
            ],
            'subscription.keys.p256dh' => [
                'required',
                'string',
            ],
            'subscription.keys.auth' => [
                'required',
                'string',
            ],
        ];
    }
}
