<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('description_en')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->string('type', '10')->comment('video, vimeo')->default('video');
            $table->string('thumb_image')->nullable();
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->string('document')->nullable();
            $table->string('vimeo_url')->nullable();
            $table->text('vimeo_embeded_code')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('is_comment_allowed')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->date('bonus_start_date')->nullable();
            $table->date('bonus_end_date')->nullable();
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
        Schema::dropIfExists('lessons');
    }
}
