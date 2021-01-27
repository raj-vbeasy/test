<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsInEventActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_activities', function (Blueprint $table) {
            $table->tinyInteger('status');
            $table->tinyInteger('hold_position');
            $table->dateTime('offer_expiration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_activities', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('hold_position');
            $table->dropColumn('offer_expiration_date');
        });
    }
}
