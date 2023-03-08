<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiveMinVideoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('five_min_video_lists', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('type')->nullable();
            $table->string('count')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->nullable();
            $table->string('file_path')->nullable();
            $table->string('normalball')->nullable();
            $table->string('powerball')->nullable();
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
        Schema::dropIfExists('five_min_video_lists');
    }
}
