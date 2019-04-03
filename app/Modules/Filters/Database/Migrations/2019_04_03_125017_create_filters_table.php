<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active');
            $table->softDeletes();
            $table->nestedSet();
            $table->timestamps();
        });

        Schema::create('filters_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('filter_id')->unsigned();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('locale')->index();

            $table->foreign('filter_id')
                ->references('id')->on('filters')
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
        Schema::drop('filters');
        Schema::drop('filters_translations');
    }
}
