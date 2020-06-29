<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->unique()->index();
            $table->string('width');
            $table->string('height');
            $table->text('description')->nullable();
            $table->string('alt')->nullable();
            $table->string('credit')->nullable(); // Used for amp-img attribution
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
