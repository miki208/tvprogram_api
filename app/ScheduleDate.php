<?php
/**
 * Created by PhpStorm.
 * User: miki208
 * Date: 02/02/2017
 * Time: 23:57
 */

namespace app;


use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    protected $table = 'schedule_date';
    protected $primaryKey = ['tv_program_id', 's_date'];
    public $incrementing = false;
    public $timestamps = false;
}