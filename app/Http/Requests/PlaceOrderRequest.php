<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class PlaceOrderRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|email',
                'delivery_method' => 'required|string',
                'payment_method' => 'required|string',
            ];
        }
    }
