<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('appname');
            $table->string('logoapp')->default('logo.png');
            $table->string('splashscreen')->default('splashscreen.png');
            $table->string('appidentificationkey')->unique();
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
        Schema::dropIfExists('my_apps');
    }
}
