<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles');
            $table->foreignId('playlist_id')->constrained('playlists');
            $table->string('text',  999);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist_comments');
    }
};
