<?php
namespace App\Services;

use App\Models\Note;
use App\Models\User;
use Exception;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Support\Facades\Log;

class NotesService {
    

    public static function find_by_id(int $id) : Note {
        return Note::find($id);
    }

    /**
     * Creates a new notes related to an user
     * @param array $noteData = user_id | title
     * @return int id
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

    /**
     * Update notes info
     * @param array $noteData = content | title | hold
     * @return bool
     */
    public static function update(array $noteData): bool {
        try{
            $note = Note::find($noteData['id']);
            $data = [];

            if(isset($noteData['content'])) $data['content'] = $noteData['content'];

            if(isset($noteData['title'])) $data['title'] = $noteData['title'];

            $data["updated_at"] = date("Y-m-d H:i:s");

            $note->update($data);
            return true;
        }catch(Exception $e){
            Log::critical($e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a note
     * @param int id
     * @return bool
     */
    public static function delete(int $id): bool {
        $note = Note::find($id);
        if(!$note) throw new Exception("note id not found.",404);
        $note->delete();

        return true;
    }
}