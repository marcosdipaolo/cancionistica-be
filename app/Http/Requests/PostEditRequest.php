<?php

namespace App\Http\Requests;

class PostEditRequest extends PostCreateRequest
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
        return array_merge(parent::rules(), [
            "image" => "nullable|file|mimetypes:image/jpeg,image/png"
        ]);
    }
}
