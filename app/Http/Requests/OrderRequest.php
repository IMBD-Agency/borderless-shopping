<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'product_urls' => 'required|array|min:1',
            'product_urls.*' => 'required|url',
            'product_quantities' => 'required_with:product_urls|array',
            'product_quantities.*' => 'required|integer|min:1',

            // Recipient and meta
            'recipient_name' => 'required|string',
            'recipient_mobile' => 'required|string',
            'recipient_email' => 'nullable|email',
            'recipient_address' => 'required|string',
            'notes' => 'nullable|string',

            // Auth flow fields (optional)
            'action' => 'sometimes|in:login,register',
            'email' => 'sometimes|required_if:action,login,register|email',
            'password' => 'sometimes|required_if:action,login,register|string|min:6',
            'name' => 'sometimes|required_if:action,register|string|min:2',
        ];
    }
}
