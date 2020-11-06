<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chartmetric_artist_id');
            $table->string('name');
            $table->string('code2')->nullable();
            $table->string('gender');
            $table->unsignedBigInteger('cm_artist_rank');
            $table->string('cover_url')->nullable();
            $table->string('image_url')->nullable();
            $table->string('hometown_city')->nullable();
            $table->string('current_city')->nullable();
            $table->string('record_label')->nullable();
            $table->string('band_members')->nullable();
            $table->string('press_contact')->nullable();
            $table->string('booking_agent')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->json('cm_statistics')->nullable();
            $table->unsignedInteger('spotify_popularity')->default(0);
            $table->unsignedBigInteger('spotify_followers')->default(0);
            $table->unsignedBigInteger('spotify_monthly_listeners')->default(0);
            $table->unsignedInteger('spotify_listeners_to_followers_ratio')->default(0);
            $table->unsignedBigInteger('facebook_likes')->default(0);
            $table->unsignedBigInteger('facebook_talks')->default(0);
            $table->unsignedBigInteger('youtube_channel_views')->default(0);
            $table->unsignedBigInteger('youtube_subscribers')->default(0);
            $table->unsignedBigInteger('wikipedia_views')->default(0);
            $table->unsignedBigInteger('soundcloud_followers')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
    }
}
