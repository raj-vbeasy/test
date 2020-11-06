<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigSaladArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_salad_artists', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->nullable();
            $table->string('Location')->nullable();
            $table->string('Category')->nullable();
            $table->string('Price')->nullable();
            $table->string('Distance')->nullable();
            $table->text('OverviewContent')->nullable();
            $table->string('Website')->nullable();
            $table->string('Phone')->nullable();
            $table->json('Texts')->nullable();
            $table->json('Categories')->nullable();
            $table->json('Videos')->nullable();
            $table->json('Photos')->nullable();
            $table->json('Audios')->nullable();
            $table->string('Link')->nullable();
            $table->string('gig_salad_id')->nullable();
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
        Schema::dropIfExists('gig_salad_artists');
    }
}
