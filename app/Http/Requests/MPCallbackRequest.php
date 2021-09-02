<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MPCallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "collection_id" => "required|string",
            "collection_status" => "required|string",
            "payment_id" => "required|string",
            "status" => "required|string",
            "payment_type" => "required|string",
            "merchant_order_id" => "required|string",
            "preference_id" => "required|string",
            "site_id" => "required|string",
            "processing_mode" => "required|string",
        ];
    }
}
