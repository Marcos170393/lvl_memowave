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
        protected ResponseHelper $responseHelper 
    ){}

    public function create(Request $request): JsonResponse {
        $data = json_decode($request->getContent(),true);
        $validator = Validator($data,[
            'user_id' => 'required|integer',
            'title' => 'required|max:100'
        ]);
        if($validator->fails()){
            Log::info($validator->errors());
            return $this->responseHelper::error($validator->errors(),400);
        }

        try{

            $result = $this->notesService::create($data);
            return $this->responseHelper::success(["id"=> $result],200);

        }catch(NotFoundException $e){
            Log::critical($e->getMessage());
            return $this->responseHelper::error($e->getMessage(),400);
        }catch(Exception $e){
            Log::critical($e->getMessage());
            return $this->responseHelper::error($e->getMessage(),$e->getCode());
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
            return $this->responseHelper::error($validator->errors(),400);
        }
        try{
            $result = $this->notesService::update($data);
            return $this->responseHelper::success(["result"=> "success"],200);
        }catch(Exception $e){
            return $this->responseHelper::error($e->getMessage(),400);
        }
    }

    public function delete(int $id): JsonResponse {
        try{
            $this->notesService::delete($id);
            return $this->responseHelper::success(['result'=>'success'], 200);
        }catch(Exception $e){
            Log::critical($e->getMessage());
            return $this->responseHelper::error($e->getMessage(),$e->getCode());
        }
    }
}
