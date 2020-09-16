<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loginlog', function (Blueprint $table) {
            $table->bigIncrements('Loginid');
            $table->String('Deviceid');
            $table->integer('Userid');
            $table->String('Token');
            $table->String('Ip');
            $table->timestamps('expired');
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
        Schema::dropIfExists('_loginlog');
    }
}
