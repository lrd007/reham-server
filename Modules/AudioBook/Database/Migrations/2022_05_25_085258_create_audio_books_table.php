<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_books', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('author_ar')->nullable();
            $table->string('author_en')->nullable();
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->string('file')->nullable();
            $table->boolean('is_playable')->default(0);
            $table->boolean('is_downloadable')->default(0);
            $table->string('duration')->nullable();
            $table->timestamp('schedule')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_books');
    }
}
