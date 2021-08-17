<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostEditRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Cancionistica\Apis\ImageableApi;
use Exception;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __construct(public ImageableApi $imageableApi)
    {
//        $this->middleware("auth:sanctum")->only(["store", "update", "delete"]);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(Post::with(["images", "postCategory"])->get());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage(), "trace" => $e->getTrace()]);
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
            if ($request->hasCategory()) {
                $cat = PostCategory::find($request->getCategoryId());
                $post->postCategory()->associate($cat);
            }
            $post->save();
            if (!$request->hasFile("image")) {
                throw new Exception("Image missing");
            }
            $this->imageableApi->saveImage($post, $request->getImage());
            return response()->json($post->load(["images", "postCategory"]));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage(), "trace" => $e->getTrace()]);
        }
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        try {
            $post->load(["images", "postCategory"]);
            return response()->json($post);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage(), "trace" => $e->getTrace()]);
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
            if ($request->hasCategory()) {
                logger()->info("updating category");
                $cat = PostCategory::find($request->getCategoryId());
                logger()->info($cat);
                $post->postCategory()->associate($cat);
            }
            $post->save();
            if ($request->hasFile("image")) {
                logger()->info("updating image");
                logger()->info($request->getImage());
                $this->imageableApi->deleteImages($post);
                $this->imageableApi->saveImage($post, $request->getImage());
            }
            return response()->json($post->fresh()->load(["images", "postCategory"]));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage(), "trace" => $e->getTrace()]);
        }
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            $this->imageableApi->deleteImages($post);
            return response()->json($post->delete());
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage(), "trace" => $e->getTrace()]);
        }
    }
}
