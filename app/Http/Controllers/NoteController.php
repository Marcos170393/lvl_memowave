<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\NotesService;
use Exception;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;

class NoteController extends Controller
{
    public function create(Request $request){
        $data = json_decode($request->getContent(),true);
        $validator = Validator($data,[
            'user_id' => 'required|integer',
            'title' => 'required|max:100'
        ]);
        if($validator->fails()){
            Log::info($validator->errors());
            return ResponseHelper::error($validator->errors(),400);
        }

        try{
            
            $result = NotesService::create($data);
            return ResponseHelper::success(["id"=> $result],200);

        }catch(NotFoundException $e){
            Log::critical($e->getMessage());
            return ResponseHelper::error($e->getMessage(),400);
        }catch(Exception $e){
            Log::critical($e->getMessage());
            return ResponseHelper::error($e->getMessage(),$e->getCode());
        }
    }
}
