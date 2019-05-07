<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active');
            $table->string('key');
            $table->nestedSet();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('blocks_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('block_id')->unsigned();
            $table->longText('description')->nullable()->default(null);
            $table->string('locale')->index();

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
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
        Schema::drop('blocks');
        Schema::drop('blocks_translations');
    }
}
