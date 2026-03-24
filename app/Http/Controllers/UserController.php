<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
        $data = $request->validated();
        try {
            $result = UserService::save($data);
            return ResponseHelper::success(["id" => $result, "username" => $data['username']], 200);
        } catch(QueryException $e) {
            Log::critical($e->getMessage());
            return ResponseHelper::error('Error creating user. Try again or chose another username',400);
        } catch (Exception $e) {
            Log::critical($e->getMessage());
            return ResponseHelper::error('Error creating user', 500);
        }
    }

    public function getUserNotes(string $userId): JsonResponse
    {
        try{
            $userNotes = UserService::findAllNotesByUserId($userId);
            return ResponseHelper::success(['notes'=>$userNotes],200);
        }catch(Exception $e){
           Log::critical($e);
           return ResponseHelper::error("Error getting user notes",500);
        }
    }
}
