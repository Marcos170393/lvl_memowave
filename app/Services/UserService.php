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

    public static function save($userData): int {
        try{
            $user['username'] = $userData['username'];
            $user['password'] = Hash::make($userData['password']);
            $result = User::insertGetId($user);
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }

    public static function findAllNotesByUserId($userId){
        try {
            $userNotes = User::find($userId)->notes()->get()->makeHidden('pivot');
            return $userNotes;
        } catch (QueryException $e) {
            Log::critical($e);
            throw $e;
        }
    }
}
