<?php

namespace App\Console\Commands;

use App\gorevlist;
use Illuminate\Console\Command;
use App\Helpers\apiHelper;

class apiInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiInsert {apiUrl*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         $url = $this->argument('apiUrl');
         $apifirst = apiHelper::getService($url[0]);
         $apisecond = apiHelper::getService($url[1]);
         $apifirstDecode = json_decode( json_encode($apifirst),true);
         $apisecondDecode = json_decode( json_encode($apisecond),true);


         foreach ($apifirstDecode as $list => $key) {
                 $tasks = new gorevlist();
                 $tasks->level = $key['zorluk'];
                 $tasks->time = $key['sure'];
                 $tasks->task_id = $key['id'];
                 $tasks->save();

                 //daily user working 5 hour

         }
         foreach ($apisecondDecode as $key => $value) {

             foreach ($value as $keyx => $valuex) {


                 $tasks = new gorevlist();
                 $tasks->level = $valuex['level'];
                 $tasks->time = $valuex['estimated_duration'];
                 $tasks->task_id = $keyx;
                 $tasks->save();
             }

         }



    }


}
