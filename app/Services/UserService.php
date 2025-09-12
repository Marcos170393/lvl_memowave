<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use stdClass;

class UserService
{
    public static function checkCredentials($username, $password): stdClass | null {
        try{

            $user = User::where('username', $username)->first();
            if ($user && Hash::check($password, $user->password)) {
                $response = new stdClass();
                $response->username = $user->username;
                $response->id = $user->id;
                return $response;
            }
            return null;
        } catch(QueryException $e) {
            Log::critical($e->getMessage());
            throw $e;
        }
    }
}
