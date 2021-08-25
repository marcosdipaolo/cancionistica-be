<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(Course::with(["images"])->get());
        } catch(\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * @param Course $course
     * @return JsonResponse
     */
    public function show(Course $course): JsonResponse
    {
        try {
            return response()->json($course->load("images"));
        } catch(\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
