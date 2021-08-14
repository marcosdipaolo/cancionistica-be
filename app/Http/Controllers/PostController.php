<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostEditRequest;
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
            return response()->json(Post::all());
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
            $path = $this->saveImage($request->image);
            $post->image_url = $path;
            $post->save();
            return response()->json($post);
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
            if($request->hasFile("image")) {
                $path = $this->saveImage($request->image);
                Storage::disk("public")->delete($post->image_url);
                $post->image_url = $path;
            }
            $post->save();
            return response()->json($post);
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
            Storage::disk("public")->delete($post->image_url);
            return response()->json($post->delete());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    private function saveImage(UploadedFile $image): string
    {
        return Storage::disk("public")->putFile("images", $image);
    }
}
