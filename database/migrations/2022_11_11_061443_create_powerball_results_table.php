<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowerballResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powerball_results', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('round')->nullable();
            $table->string('result')->nullable();
            $table->string('normalball')->nullable();
            $table->string('powerball')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('powerball_results');
    }
}
