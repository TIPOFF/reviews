<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index(); // ID on YouTube.
            $table->string('source')->default('youtube');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('image_id')->nullable()->references('id')->on('images'); // Placeholder image for the video

            $table->foreignId('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
