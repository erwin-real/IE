<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSingleForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_forecasts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forecast_id');
            $table->unsignedInteger('year');
            $table->unsignedInteger('month');
            $table->unsignedInteger('size');
            $table->unsignedInteger('demand');
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
        Schema::dropIfExists('single_forecasts');
    }
}
