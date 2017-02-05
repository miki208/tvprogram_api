<?php
/**
 * Created by PhpStorm.
 * User: miki208
 * Date: 4.2.17.
 * Time: 00.34
 */

namespace app\Console\Commands;

use Illuminate\Console\Command;
use App\Schedule;
use App\ScheduleDate;
use App\TvProgram;


class LoadSchedules extends Command
{
    protected $name = 'load_schedules';
    protected $description = 'Load schedules for tv programs';

    public function fire() {
    	date_default_timezone_set('Europe/Belgrade');
    	
        $day_names = array('nedelja', 'ponedeljak', 'utorak', 'sreda', 'cetvrtak', 'petak', 'subota', 'nedelja', 'ponedeljak');
        $datetime = time() + 3600;
        $day = date('w', $datetime);
        $tvprograms = TvProgram::all();

        for($i = $day; $i < $day + 3; $i++) {
            $day_name = $day_names[$i];
            $date = date('Y-m-d', $datetime + ($i - $day) * 24 * 3600);

            foreach($tvprograms as $tvprogram) {
                $content = file_get_contents("http://www.tvprogram.rs/{$tvprogram->name}-tv-program-{$day_name}.{$tvprogram->uri}.html");
                preg_match_all('/<ul class="tv-serije-lista-inner clearfix">.*?<li class="list-inner-sat">.*?<span class="satnica">(.*?)<\\/span>.*?<p>(?:<a.*?>)?(.*?)(?:<\\/a>)?<\\/p>/s', $content, $matches);
                ScheduleDate::where('tv_program_id', $tvprogram->id)->where('s_date', $date)->delete();
                $obj1 = new ScheduleDate();
                $obj1->tv_program_id = $tvprogram->id;
                $obj1->s_date = $date;
                $obj1->updated_at = date('Y-m-d', time());
                $obj1->save();

                $length = count($matches[0]);
                for($j = 0; $j < $length; $j++) {
                    try {
                        $obj2 = new Schedule();
                        $obj2->tv_program_id = $tvprogram->id;
                        $obj2->s_date = $date;
                        $obj2->s_time = $matches[1][$j];
                        $obj2->title = $matches[2][$j];
                        $obj2->save();
                    } catch(\Illuminate\Database\QueryException $e) {

                    }
                }
            }
        }
    }
}
