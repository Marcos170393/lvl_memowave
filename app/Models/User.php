<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class User extends Model
{

    /**
     * Class attributes
     */
    private $password;
    private $username;
    private $updated_at;
    private $created_at;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
    ];



    public function __set($key, $value)
    {
        if (!property_exists($this, $key) && !array_key_exists($key, $this->attributes)) {
            throw new Exception("La propiedad '{$key}' no existe en el modelo User.");
        }

        parent::__set($key, $value);
    }

    /**

     * The roles that belong to the user.

     */

    public function notes(): BelongsToMany

    {

        return $this->belongsToMany(Note::class, 'user_notes');
    }
}
