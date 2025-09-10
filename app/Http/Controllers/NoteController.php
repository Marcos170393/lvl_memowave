<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function findAll(Request $request){
        return ResponseHelper::success(["resultado"=>'OK'],200);
    }
}
