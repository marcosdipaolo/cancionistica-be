<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return response()->json(Course::with(["images"])->get());
        } catch(\Throwable $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
}
