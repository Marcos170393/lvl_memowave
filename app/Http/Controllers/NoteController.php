<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\NotesService;
use Exception;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{

    public function __construct(
        protected NotesService $notesService,
    ){}

    public function create(Request $request): JsonResponse {
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

            $result = $this->notesService::create($data);
            return ResponseHelper::success(["id"=> $result],200);

        }catch(NotFoundException $e){
            Log::critical($e->getMessage());
            return ResponseHelper::error($e->getMessage(),400);
        }catch(Exception $e){
            Log::critical($e->getMessage());
            return ResponseHelper::error($e->getMessage(),$e->getCode());
        }
    }

    public function update(Request $request): JsonResponse {
        $data = json_decode($request->getContent(),true);
        $validator = Validator($data,[
            'id' => 'exists:notes,id',
            'content' => 'sometimes|required|min:1',
            'title' => 'sometimes|required|min:1'
        ]);

        if($validator->fails()){
            return ResponseHelper::error($validator->errors(),400);
        }

        try{
            $result = $this->notesService::update($data);
            return ResponseHelper::success(["status"=> "success"],200);
        }catch(Exception $e){
            return ResponseHelper::error($e->getMessage(),400);
        }
    }
}
