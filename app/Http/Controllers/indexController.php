<?php

namespace App\Http\Controllers;

use App\gorevlist;
use App\Helpers\apiHelper;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        $gorevlist=gorevlist::where('level','=','1')->get();


        $developers = [
            ['name' => 'DEV1', 'level' => 1],
            ['name' => 'DEV2', 'level' => 2],
            ['name' => 'DEV3', 'level' => 3],
            ['name' => 'DEV4', 'level' => 4],
            ['name' => 'DEV5', 'level' => 5],
        ];



        $taskfordevelopers = apiHelper::getDevelopersWithTasks($developers);

        $finish=0;
        foreach ($taskfordevelopers as $key => $value){

            $time= count($value['weekly']);
            if($time > $finish){$finish=$time;}

        }


        return view('index',['taskfordevelopers'=>$taskfordevelopers,'finish'=>$finish]);
    }
}
