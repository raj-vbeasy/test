<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->foreign('artist_id')->references('id')->on('artists');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->string('crew')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->text('description');
            $table->enum('type', ['stage', 'crew', 'other', 'important']);
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
        Schema::dropIfExists('event_activities');
    }
}
