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
            $table->string('Updatedby');
            $table->string('Closedby');
            $table->string('Assignment');
            $table->string('Subject');
            $table->string('Tel');
            $table->string('Comname');
            $table->string('Informer');
            $table->longText('Description');
            $table->string('Uuid');
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
