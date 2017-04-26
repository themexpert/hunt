<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string("company")->default('ThemeXpert');
            $table->string("language")->default('en');
            $table->string("copyright")->default('&copy; 2010-'.date('Y').' ThemeXpert Inc. All Rights Reserved.');
            $table->string("logo")->default("/images/logo.png");
            $table->string("favicon")->default("/images/favicon.png");
            $table->timestamps();
        });

        DB::table('settings')->insert(['language'=>'en']);
        @copy(public_path('images').'/logo-hunt.png', public_path('images').'/logo.png');
        @copy(public_path('images').'/favicon-hunt.png', public_path('images').'/favicon.png');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
