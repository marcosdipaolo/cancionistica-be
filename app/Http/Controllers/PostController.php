<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostEditRequest;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->only([["store", "update", "delete"]]);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(Post::with("image")->get());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function store(PostCreateRequest $request): JsonResponse
    {
        try {
            $post = new Post($request->only("title", "sub_title", "content"));
            $path = $this->storeImageFile($request->image);
            $post->save();
            $post->image()->create(["path" => $path]);
            return response()->json($post->load("image"));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        try {
            $post->load("image");
            return response()->json($post);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * @param PostEditRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(PostEditRequest $request, Post $post): JsonResponse
    {
        try {
            $post->fill($request->only("title", "sub_title", "content"));
            $post->save();
            if ($request->hasFile("image")) {
                $path = $this->storeImageFile($request->image);
                Storage::disk("public")->delete($post->image->path);
                $post->image()->delete();
                $post->image()->create(["path" => $path]);
            }
            return response()->json($post->fresh()->load("image"));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            Storage::disk("public")->delete($post->image->path);
            $post->image()->delete();
            return response()->json($post->delete());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    private function storeImageFile(UploadedFile $image): string
    {
        return Storage::disk("public")->putFile("images", $image);
    }
}
