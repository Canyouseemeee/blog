<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('Issuesid');
            $table->Integer('Trackerid');
            $table->Integer('Priorityid');
            $table->Integer('Statusid');
            $table->Integer('Departmentid');
            $table->string('Createby');
            $table->string('Userid');
            $table->string('Subject');
            $table->longText('Description');
            $table->date('Date_In');
            $table->mediumText('Image')->nullable();
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
        Schema::dropIfExists('issues');
    }
}
