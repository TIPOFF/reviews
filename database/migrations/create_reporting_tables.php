<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateReportingTables
 */
class CreateReportingTables extends Migration
{

    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }
}
