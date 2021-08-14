<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
            "title" => "required|string|min:2",
            "sub_title" => "required|string|min:2",
            "image" => "required|file|mimetypes:image/jpeg,image/png",
            "content" => "required|string|min:10"
        ];
    }
}
