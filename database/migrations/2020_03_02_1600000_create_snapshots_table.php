<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnapshotsTable extends Migration
{
    public function up()
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->references('id')->on('places');
            $table->date('date');
            $table->smallInteger('reviews')->nullable();
            $table->unsignedDecimal('rating', 2, 1)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('snapshots');
    }
}
