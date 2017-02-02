<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableScheduleDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_date', function($table) {
            $table->date('s_date');
            $table->integer('tv_program_id')->unsigned();
            $table->date('updated_at');

            $table->primary(['tv_program_id', 's_date']);
            $table->foreign('tv_program_id')->references('id')->on('tv_program')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('schedule_date');
    }
}
