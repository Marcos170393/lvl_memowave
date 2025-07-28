<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_notes', function (Blueprint $table) {
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Note::class);
            $table->index(["user_id", "note_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notes');
    }
};
