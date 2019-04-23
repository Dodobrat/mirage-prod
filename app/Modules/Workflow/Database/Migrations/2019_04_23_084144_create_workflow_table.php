<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active');
            $table->string('access_key');
            $table->nestedSet();
            $table->timestamps();
        });

        Schema::create('workflow_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('workflow_id')->unsigned();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('locale')->index();

            $table->foreign('workflow_id')
                ->references('id')->on('workflow')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('workflow');
        Schema::drop('workflow_translations');
    }
}
