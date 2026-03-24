<?php
namespace App\Services;

use App\Models\Note;
use App\Models\User;
use Exception;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Support\Facades\Log;

class NotesService {
    
    /**
     * Creates a new notes related to an user
     */
    public static function create(array $noteData) : int {
        $user = User::find($noteData['user_id']);
        if(!$user){
            throw new NotFoundException("user id: {$noteData['user_id']} not found");
        }
        try{

            $newNote = new Note();
            $newNote->title = $noteData['title'];
            $newNote->save();
            $newNote->users()->attach($user->id);

            return $newNote->id;

        }catch(Exception $e){
            Log::critical($e->getMessage());
            throw $e;
        }
    }
}