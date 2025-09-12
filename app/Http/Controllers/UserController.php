<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use stdClass;

class UserController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = (object) $request->validated();
        try {
            $user = UserService::checkCredentials($data->username,$data->password);
            if ($user) return ResponseHelper::success($user,200);

            return ResponseHelper::error("user or password incorrect",401);
        }catch (Exception $e) {
            Log::critical($e->getMessage());
            return ResponseHelper::error('Unexpected error', 500);
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = (object) $request->validated();
        try {
            $user = new User();
            $user->username = $data->username;
            $user->password = Hash::make($data->password);
            $result = User::insertGetId($user->toArray());

            return ResponseHelper::success(["id" => $result, "username" => $user->username], 200);
        } catch(QueryException $e) {
            Log::critical($e->getMessage());
            return ResponseHelper::error('Error creating user. Try again or chose another username',400);
        } catch (Exception $e) {
            Log::critical($e->getMessage());
            return ResponseHelper::error('Error creating user', 500);
        }
    }
}
