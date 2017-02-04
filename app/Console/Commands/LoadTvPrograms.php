<?php
/**
 * Created by PhpStorm.
 * User: miki208
 * Date: 4.2.17.
 * Time: 00.27
 */

namespace app\Console\Commands;

use \Illuminate\Console\Command;
use App\TvProgram;
use Illuminate\Support\Facades\Schema;

class LoadTvPrograms extends Command
{
    protected $name = 'load_tv_programs';
    protected $description = 'Load data for table tv_programs';

    public function fire() {
        $content = file_get_contents('http://www.tvprogram.rs/');
        preg_match_all('/<li><a href="http:\\/\\/www\\.tvprogram\\.rs\\/(.*?)-tv-program-.*?\\.([0-9]+)\\.html">.*?<\\/li>/s', $content, $matches);

        Schema::disableForeignKeyConstraints();
        TvProgram::truncate();
        Schema::enableForeignKeyConstraints();

        $length = count($matches[0]);
        for ($i = 0; $i < $length; $i++) {
            $obj = new TvProgram();
            $obj->name = $matches[1][$i];
            $obj->uri = $matches[2][$i];
            $obj->save();
        }
    }
}