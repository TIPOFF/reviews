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

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name')->unique(); // Internal reference name
            $table->string('title_part')->nullable(); // For when have more than one location in a market, this is used to generate formal title.
            $table->string('timezone'); // Informal symbol such as EST or CST
            $table->string('gmb_location')->nullable()->unique(); // GMB ID for API. Will be used to update all the other fields below.
            $table->string('gmb_account')->nullable();

            // All updated from GMB so have one place as source of truth
            $table->string('title')->nullable()->unique(); // Location Title for display from GMB.
            $table->date('opened_at')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip', 5)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('monday_open')->nullable();
            $table->string('monday_close')->nullable();
            $table->string('tuesday_open')->nullable();
            $table->string('tuesday_close')->nullable();
            $table->string('wednesday_open')->nullable();
            $table->string('wednesday_close')->nullable();
            $table->string('thursday_open')->nullable();
            $table->string('thursday_close')->nullable();
            $table->string('friday_open')->nullable();
            $table->string('friday_close')->nullable();
            $table->string('saturday_open')->nullable();
            $table->string('saturday_close')->nullable();
            $table->string('sunday_open')->nullable();
            $table->string('sunday_close')->nullable();
            $table->string('maps_url')->nullable()->unique(); // URL for location's Google My Business / Google Maps page.
            $table->string('review_url')->nullable()->unique(); // URL for a new review at the location.
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('place_location')->nullable()->unique(); // Google Places ID
            $table->smallInteger('gmb_reviews')->nullable(); // Number of Google Reviews for Location
            $table->unsignedDecimal('gmb_rating', 2, 1)->nullable(); // Google Review Aggregate for Location
            $table->date('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->string('place_location')->unique(); // Google Places ID
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip', 5)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('maps_url')->nullable()->unique();
            $table->string('website')->nullable();
            $table->string('monday_open')->nullable();
            $table->string('monday_close')->nullable();
            $table->string('tuesday_open')->nullable();
            $table->string('tuesday_close')->nullable();
            $table->string('wednesday_open')->nullable();
            $table->string('wednesday_close')->nullable();
            $table->string('thursday_open')->nullable();
            $table->string('thursday_close')->nullable();
            $table->string('friday_open')->nullable();
            $table->string('friday_close')->nullable();
            $table->string('saturday_open')->nullable();
            $table->string('saturday_close')->nullable();
            $table->string('sunday_open')->nullable();
            $table->string('sunday_close')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreignId('location_id')->nullable()->unique()->references('id')->on('locations'); // Identify our locations in this table
            $table->timestamps();
        });

        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competitor_id')->references('id')->on('competitors');
            $table->date('date');
            $table->smallInteger('reviews')->nullable();
            $table->unsignedDecimal('rating', 2, 1)->nullable();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('google_ref')->unique(); // Google Review ID reference
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('reviewer')->nullable(); // Name of reviewer
            $table->string('reviewer_photo')->nullable(); // URL of photo image
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('review_updated_at')->nullable();
            $table->text('reply')->nullable();
            $table->timestamp('replied_at')->nullable(); // Really is the last time the reply was updated
            $table->boolean('is_displayable')->default(false); // Mark true if review should be displayed on website
            $table->boolean('is_photo_displayable')->default(false); // Mark true if website should display the reviewer_photo as well or just use the yellow placeholder
            $table->string('reviewer_displayable')->nullable(); // Allows modifying reviewer name for display on website. If null, will just use actual reviewer name.
            $table->string('title_displayable')->nullable(); // Quick bold title excerpt from the comment. If null, will default to "5 out of 5 stars!" or some generic title based on 5 star rating
            $table->text('comment_displayable')->nullable(); // Allows modifying review comment for display on website (mostly for grammar, not content). If null, will just use actual review comment.
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->timestamps();
        });

        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->references('id')->on('locations');
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
