<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('capacity')->default(0);
            $table->text('location');
            $table->decimal('tax_rate')->default(0);
            $table->decimal('facility_fee')->default(0);
            $table->unsignedInteger('timezone_id');
            $table->foreign('timezone_id')->references('id')->on('timezones');
            $table->string('currency')->default('USD');
            $table->string('event_template')->nullable();
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
        Schema::dropIfExists('performance_locations');
    }
}
