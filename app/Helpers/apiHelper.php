<?php


namespace App\Helpers;


use App\gorevlist;
use App\Models\ToDo as ToDoModel;

trait apiHelper
{
    public static function getService($url){

        $c_url = curl_init($url);
        curl_setopt($c_url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c_url, CURLOPT_TIMEOUT,600);
        $return = curl_exec($c_url);
        if(!curl_errno($c_url))
        {
            echo 'basarili';
        }
        curl_close($c_url);

        $dizi = json_decode($return);

        return $dizi;
    }

    public static function getDevelopersWithTasks(array $devList = [])
    {
        $tasks = self::developersWithTasks($devList);
        foreach ($tasks as $key => $developers) {
            $tasks[$key]['name']  = $developers['name'];
            $tasks[$key]['level'] = $developers['level'];
            $tasks[$key]['time']  = $developers['time'];
            $tasks[$key]['weekly'] = self::groupWeek($developers['tasks'],$tasks[$key]['level']);
        }
        return $tasks;
    }

    private static function developersWithTasks(array $devList = [])
    {
        $tasks = gorevlist::orderBy('time', 'desc')->get();

        // Görevleri zorluklarına göre gruplandıralım
        $tasksGroup = [];

        foreach ($tasks as $task) {
            $tasksGroup[$task->level][] = ['task_id' => $task->task_id, 'time' => $task->time,'level' => $task->level];
        }

        krsort($tasksGroup);

        // Developerları iş zorlukarına göre sıralamayalım
        $developers = [];

        foreach ($devList as $developer) {
            $developers[$developer['level']] = ['name' => $developer['name'], 'level' => $developer['level'], 'time' => 0];
        }


        foreach ($tasksGroup as $level => $tasks) {

            foreach ($tasks as $task) {

                $devlevel = self::devfortasks($developers, $level);
                $developers[$devlevel]['tasks'][] = array_merge($task, ['level' => $level]);
                $developers[$devlevel]['time']    += $task['time'];
            }

        }


        return $developers;

    }

   // Zamanı olan developerlara klan taskleri gönderiyoruz.
    private static function devfortasks($developers, $level)
    {

        $developer = $developers[$level];

        ksort($developers);


        $index = array_search($level, array_keys($developers));

        $upperLevelDeveloper = array_slice($developers, $index + 1, 1, true);

        if ( ! isset($upperLevelDeveloper[$level + 1]['time'])) {
            return $level;
        } elseif ($developer['time'] <= $upperLevelDeveloper[$level + 1]['time']) {
            return $level;
        } else {

            $upperLevel = self::devfortasks($developers, $level + 1);

            if ($upperLevel == $level) {
                return $level;

            } else {
                return $upperLevel;
            }
        }

    }

    private static function groupWeek(array $tasks = [],$level)
    {

        $devlevel=$level;
        $weeklyTasks = [
            [
                'tasks' => [],
                'time'  => 0,
            ],
        ];

        foreach ($tasks as $task) {

            $taskTime = $task['time'];

            foreach ($weeklyTasks as $key => $week) {


                if ($week['time'] < 45 && ($week['time'] + $taskTime) <= 45) {

                    if($task['level']==$devlevel){

                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time']    += $taskTime;

                    }
                    else{

                        $task['time']=($taskTime*$task['level'])/$devlevel;

                        $weeklyTasks[$key]['tasks'][] = $task;

                        $weeklyTasks[$key]['tasks']['time'] = ($taskTime*$task['level'])/$devlevel;
                        $weeklyTasks[$key]['time']    += ($taskTime*$task['level'])/$devlevel;

                    }

                    break;

                }

                if ($week['time'] < 45 && ($week['time'] + $taskTime) > 45) {

                    if($task['level']==$devlevel){

                        $time                         = 45 - $week['time'];
                        $taskTime                     -= $time;
                        $task['time']                 = $time;
                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time']    += $time;

                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];
                    }
                    else {

                        $time                         = 45 - $week['time'];
                        $taskTime                     -= $time;
                        $task['time']                 = $time;
                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time']    += $time;

                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];

                    }
                    break;

                }

                if ($week['time'] == 45 && isset($weeklyTasks[$key + 1])) {

                    continue;

                }

                if ($week['time'] == 45 && ! isset($weeklyTasks[$key + 1])) {

                    if($task['level']==$devlevel){
                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];}
                    else {
                        $task['time']  = ($taskTime*$task['level'])/$devlevel;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];
                    }




                    break;

                }





            }

        }

        return $weeklyTasks;

    }

}