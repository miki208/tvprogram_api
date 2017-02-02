<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function($table) {
            $table->time('s_time');
            $table->date('s_date');
            $table->integer('tv_program_id')->unsigned();
            $table->string('title', 100);

            $table->primary(['tv_program_id', 's_date', 's_time']);
            $table->foreign(['tv_program_id', 's_date'])->references(['tv_program_id', 's_date'])->on('schedule_date')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('schedule');
    }
}
