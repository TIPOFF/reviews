<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorsTable extends Migration
{
    public function up()
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->references('id')->on('places');
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitors');
    }
}
