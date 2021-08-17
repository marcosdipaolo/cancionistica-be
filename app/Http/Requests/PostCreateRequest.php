<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

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
            "post_category_id" => "nullable|uuid",
            "content" => "required|string|min:10"
        ];
    }

    /**
     * @return bool
     */
    public function hasCategory(): bool
    {
        return $this->has("post_category_id");
    }

    /**
     * @return string|null
     */
    public function getCategoryId(): string | null
    {
        return $this->get("post_category_id");
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->file("image");
    }
}
