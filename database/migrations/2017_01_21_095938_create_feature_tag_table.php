<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_tag', function (Blueprint $table) {
            $table->integer('feature_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->unique(['feature_id', 'tag_id']);

            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feature_tag');
    }
}
