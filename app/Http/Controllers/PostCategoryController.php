<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;

class PostCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(["index"]);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(PostCategory::all());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    public function destroy(PostCategory $postCategory): JsonResponse
    {
        try {
            $postCategory->delete();
            return response()->json([], 200);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    public function store(CategoryCreateRequest $request): JsonResponse
    {
        try {
            $category = new PostCategory(["name" => $request->getName()]);
            $category->save();
            return response()->json($category);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
