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
            "productId" => "required|uuid",
            "productName" => "required|string",
            "productPrice" => "required|numeric",
            "productQuantity" => "required|numeric",
        ];
    }

    public function getProductId(): string
    {
        return $this->get("productId");
    }

    public function getProductName(): string
    {
        return $this->get("productName");
    }

    public function getProductPrice(): string
    {
        return $this->get("productPrice");
    }

    public function getProductQuantity(): int
    {
        return $this->get("productQuantity");
    }

}
