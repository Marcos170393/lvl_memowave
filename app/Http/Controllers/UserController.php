<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use stdClass;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = (object) $request->validated();
        try {
            $user = User::where('username', $data->username)->first();
            if ($user && Hash::check($data->password, $user->password)) {
                $response = new stdClass();
                $response->username = $user->username;
                $response->id = $user->id;
                return ResponseHelper::success($response, 200);
            }
            return ResponseHelper::error('Wrong username or password', 404);
        } catch (Exception $e) {
            Log::critical($e->getMessage());
            return ResponseHelper::error('Unexpected error',500);
        }
    }

    public function store(StoreUserRequest $request)
    {
        $data = (object) $request->validated();
        try {
            $user = new User;
            $user->username = $data->username;
            $user->password = Hash::make($data->password);
            $result = User::insertGetId($user->toArray());

            return response(["id" => $result, "username" => $user->username], 200);

        } catch (Exception $e) {
            Log::critical($e->getMessage());
            // TODO generate helper to handle different types of exceptions
            return response(['message' => 'Error creating user'], 500);
        }
    }
}
