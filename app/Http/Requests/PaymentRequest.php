<?php

namespace App\Http\Requests;

use Cancionistica\DataContracts\ProductData;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest implements ProductData
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
            "items" => "required|array|min:1",
            "items.*.id" => "required|uuid",
            "items.*.title" => "required|string",
            "items.*.price" => "required|numeric",
            "items.*.quantity" => "required|numeric",
        ];
    }

    public function getItems(): array
    {
        return $this->get("items");
    }
}
