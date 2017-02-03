<?php
/**
 * Created by PhpStorm.
 * User: miki208
 * Date: 03/02/2017
 * Time: 00:02
 */

namespace app;


use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = ['tv_program_id', 's_date', 's_time'];
    public $incrementing = false;
    public $timestamps = false;
}