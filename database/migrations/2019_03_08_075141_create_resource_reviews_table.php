<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('resource_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->text('review');
            $table->unsignedInteger('stars')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('resource_reviews');
    }
}
