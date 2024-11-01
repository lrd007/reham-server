<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('description_ar');
            $table->dropColumn('description_en');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar_2')->nullable();
            $table->text('description_en_2')->nullable();
            $table->string('vimeo')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('description_ar');
            $table->dropColumn('description_en');
            $table->dropColumn('description_ar_2');
            $table->dropColumn('description_en_2');
            $table->dropColumn('vimeo');            
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->string('description_ar')->nullable();
            $table->string('description_en')->nullable();
        });
    }
}
