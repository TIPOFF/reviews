<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name')->unique();
            $table->string('title')->unique(); // Market Title for Display. Used publicly.
            $table->string('state'); // Just the 2-digit abbreviation.
            $table->string('timezone');
            $table->boolean('corporate')->default(true); // Mark false for Miami & DC

            $table->text('content')->nullable(); // Market specific content. Written in Markdown.
            $table->date('entered_at'); // Date first location opened in the market.
            $table->date('closed_at')->nullable();

            /* Sub-Pages Content */
            $table->text('rooms_content')->nullable(); // Market specific content for /escape-rooms page. Written in Markdown.
            $table->text('faq_content')->nullable(); // Frequently Asked Questions about the market (such as where to park at each location in the market). Written in Markdown.
            $table->text('competitors_content')->nullable(); // Nice paragraph about the other escape rooms in each market. First used on /escape-rooms page. Written in Markdown.

            /* Relationships */
            $table->foreignId('image_id')->nullable()->references('id')->on('images'); // Cover image for market
            $table->foreignId('ogimage_id')->nullable()->references('id')->on('images'); // External open graph image id. Featured image for social sharing. Will default to image_id unless this is used.
            $table->foreignId('map_image_id')->nullable()->references('id')->on('images'); // Image of location map for the market.
            $table->foreignId('video_id')->nullable()->references('id')->on('videos'); // Featured video for the market.

            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('updater_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('markets');
    }
}
