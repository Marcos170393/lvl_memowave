<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{

    protected $primaryKey = 'id';
    protected $fillable = ['title','content'];

    protected static function booted(): void
    {
        static::deleted(function(Note $note){
            UserNote::where("note_id",$note->id)->delete();
        });
    }
    
    /**
     * The users that belong to the role.
     */
     public function users(): BelongsToMany

     {
 
         return $this->belongsToMany(User::class,'user_notes');
 
     }
}
