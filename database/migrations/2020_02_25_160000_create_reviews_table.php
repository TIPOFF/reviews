<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('location'));
            $table->string('google_ref')->unique(); // Google Review ID reference
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('reviewer')->nullable(); // Name of reviewer
            $table->string('reviewer_photo')->nullable(); // URL of photo image
            $table->dateTime('reviewed_at')->nullable();
            $table->dateTime('review_updated_at')->nullable();
            $table->text('reply')->nullable();
            $table->dateTime('replied_at')->nullable(); // Really is the last time the reply was updated
            $table->boolean('is_displayable')->default(false); // Mark true if review should be displayed on website
            $table->boolean('is_photo_displayable')->default(false); // Mark true if website should display the reviewer_photo as well or just use the reviewer image placeholder
            $table->string('reviewer_displayable')->nullable(); // Allows modifying reviewer name for display on website. If null, will just use actual reviewer name.
            $table->string('title_displayable')->nullable(); // Quick bold title excerpt from the comment. If null, will default to "5 out of 5 stars!" or some generic title based on 5 star rating
            $table->text('comment_displayable')->nullable(); // Allows modifying review comment for display on website (mostly for grammar, not content). If null, will just use actual review comment.
            
            $table->foreignIdFor(app('user'), 'creator_id')->nullable();
            $table->foreignIdFor(app('user'), 'updater_id')->nullable();
            $table->timestamps();
        });
    }
}
