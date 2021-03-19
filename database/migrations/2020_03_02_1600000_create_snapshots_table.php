<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Reviews\Models\Competitor;

class CreateSnapshotsTable extends Migration
{
    public function up()
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Competitor::class);
            $table->date('date');
            $table->smallInteger('reviews')->nullable();
            $table->unsignedDecimal('rating', 2, 1)->nullable();
            $table->timestamp('created_at');
        });
    }
}
