<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsightsTable extends Migration
{
    public function up()
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('location'));
            $table->date('date');
            $table->unsignedInteger('searches_discovery')->nullable(); // QUERIES_INDIRECT - Customers who find your listing searching for your business name or address
            $table->unsignedInteger('searches_direct')->nullable(); // QUERIES_DIRECT - Customers who find your listing searching for a category, product, or service
            $table->unsignedInteger('searches_branded')->nullable(); // QUERIES_CHAIN - Customers who find your listing searching for a brand related to your business
            $table->unsignedInteger('views_maps')->nullable();
            $table->unsignedInteger('views_search')->nullable();
            $table->unsignedInteger('visits')->nullable(); // website visits
            $table->unsignedInteger('directions')->nullable();
            $table->unsignedInteger('calls')->nullable();
            $table->unsignedInteger('posts_views')->nullable(); // Views on local posts made to GMB
            $table->unsignedInteger('photos_views_merchant')->nullable();
            $table->unsignedInteger('photos_views_customer')->nullable();
            $table->unsignedInteger('photos_count_merchant')->nullable();
            $table->unsignedInteger('photos_count_customer')->nullable();
            $table->timestamps();
        });
    }
}
