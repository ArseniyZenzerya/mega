<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class OrderStatusRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'status' => 'required|in:new,processing,completed',
            ];
        }
    }
