<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function store(StoreUserRequest $request) {
        $data = $request->validated();
        // TODO hash password
        try {
            User::insert($data);
            return response()->json(['message'=>'OK'],200);
        } catch (\Exception $e) {
            Log::critical($e->getMessage(),['UserController','store']);
            return response()->json(['message'=>'Unexpected error'],500);
        }
        
    }
}
