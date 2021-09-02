<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalInfoCreateRequest;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class PersonalInfoController extends Controller
{
    public function show(User $user): JsonResponse
    {
        try {
            $personalInfo = $user->personalInfo;
            $status = $personalInfo instanceof PersonalInfo ? 200 : 404;
            return response()->json($personalInfo ?? ["error" => "Information not found for that user"], $status);
        } catch (\Throwable $err) {
            return response()->json(["error" => $err->getMessage()], 500);
        }
    }

    public function store(User $user, PersonalInfoCreateRequest $request): JsonResponse
    {
        try {
            if ($user->personalInfo) {
                return response()->json(["error" => "User already has his personal info saved"], 409);
            }
            $user->personalInfo()->create($request->all());
            return response()->json($user->load("personalInfo"));
        } catch (\Throwable $err) {
            return response()->json(["error" => $err->getMessage()], 500);
        }
    }

    public function update(User $user, PersonalInfoCreateRequest $request): JsonResponse
    {
        $personalInfo = $user->personalInfo;
        if (!$personalInfo) {
            return response()->json(["error" => "Information not found for that user"], 404);
        }
        $personalInfo->fill($request->all());
        $personalInfo->save();
        return response()->json($user->load("personalInfo"));
    }
}
