<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicityFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicity_firms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('publicist_name')->nullable();
            $table->string('publicist_phone')->nullable();
            $table->string('publicist_email')->nullable();
            $table->string('publicist_assistant_name')->nullable();
            $table->string('publicist_assistant_phone')->nullable();
            $table->string('publicist_assistant_email')->nullable();
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
        Schema::dropIfExists('publicity_firms');
    }
}
