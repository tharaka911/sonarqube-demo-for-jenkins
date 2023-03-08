<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balancing_data', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('round')->nullable();
            $table->string('date')->nullable();
            $table->string('ip')->nullable();
            $table->string('apiKey')->nullable();
            $table->string('pb_odd')->nullable();
            $table->string('pb_even')->nullable();
            $table->string('pb_under')->nullable();
            $table->string('pb_over')->nullable();
            $table->string('nb_odd')->nullable();
            $table->string('nb_even')->nullable();
            $table->string('nb_under')->nullable();
            $table->string('nb_over')->nullable();
            $table->string('nb_large')->nullable();
            $table->string('nb_medium')->nullable();
            $table->string('nb_small')->nullable();
            $table->string('pb_odd_under')->nullable();
            $table->string('pb_odd_over')->nullable();
            $table->string('pb_even_under')->nullable();
            $table->string('pb_even_over')->nullable();
            $table->string('nb_odd_under')->nullable();
            $table->string('nb_odd_over')->nullable();
            $table->string('nb_even_under')->nullable();
            $table->string('nb_even_over')->nullable();
            $table->string('nb_odd_large')->nullable();
            $table->string('nb_odd_medium')->nullable();
            $table->string('nb_odd_small')->nullable();
            $table->string('nb_even_large')->nullable();
            $table->string('nb_even_medium')->nullable();
            $table->string('nb_even_small')->nullable();
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
        Schema::dropIfExists('balancing_data');
    }
}
