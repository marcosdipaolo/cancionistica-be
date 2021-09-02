<?php

namespace App\Http\Requests;

use Cancionistica\DataContracts\PersonalInfoData;
use Illuminate\Foundation\Http\FormRequest;

class PersonalInfoCreateRequest extends FormRequest implements PersonalInfoData
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
            "first_name" => "required|string|min:2|max:50",
            "last_name" => "required|string|min:2|max:50",
            "phonenumber" => "required|string|min:7|max:50",
            "address_line_one" => "nullable|string",
            "address_line_two" => "nullable|string",
            "postcode" => "nullable|string|min:4|max:10",
            "city" => "nullable|string|min:2|max:50",
            "country" => "nullable|string|min:2|max:50",
        ];
    }

    public function getFirstName(): string
    {
        return $this->get("first_name");
    }
    public function getLastName(): string
    {
        return $this->get("last_name");
    }
    public function getPhonenumber(): string
    {
        return $this->get("phonenumber");
    }
    public function getAddressLineOne(): string | null
    {
        return $this->get("address_line_one");
    }
    public function getAddressLineTwo(): string | null
    {
        return $this->get("address_line_two");
    }
    public function getPostcode(): string | null
    {
        return $this->get("postcode");
    }
    public function getCity(): string | null
    {
        return $this->get("city");
    }
    public function getCountry(): string | null
    {
        return $this->get("country");
    }
}
