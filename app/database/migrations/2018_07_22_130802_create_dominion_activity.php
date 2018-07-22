<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDominionActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dominion_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('source_realm_id');
            $table->unsignedInteger('target_realm_id');
            $table->unsignedInteger('source_dominion_id');
            $table->unsignedInteger('target_dominion_id');
            $table->string('type');
            // invasion
            // spy
            // spell
            $table->boolean('success');
            $table->text('data');
            $table->timestamps();

            $table->foreign('source_dominion_id')->references('id')->on('dominions');
            $table->foreign('target_dominion_id')->references('id')->on('dominions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dominion_activity');
    }
}
