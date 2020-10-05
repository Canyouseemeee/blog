<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues_comment', function (Blueprint $table) {
            $table->bigIncrements('Commentid');
            $table->integer('Issuesid');
            $table->integer('Status');
            $table->integer('Type');
            $table->string('Comment');
            $table->string('Createby');
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
        Schema::dropIfExists('issues_comment');
    }
}
