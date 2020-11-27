<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsInArtistEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artist_event', function (Blueprint $table) {
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('management_firm_id')->nullable();
            $table->unsignedBigInteger('publicity_firm_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artist_event', function (Blueprint $table) {
            $table->dropColumn('agency_id');
            $table->dropColumn('management_firm_id');
            $table->dropColumn('publicity_firm_id');
        });
    }
}
