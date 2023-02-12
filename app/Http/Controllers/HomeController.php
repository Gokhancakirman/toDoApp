<?php

namespace App\Http\Controllers;

use App\Models\Developers;
use App\Models\Providers;

class HomeController extends Controller
{
    public function index(){
        $developers = Developers::all();
        $weeklyJobList = [];
        foreach ($developers as $developer) {
            $tasks = Providers::where('difficulty',$developer->level)->orderBy('duration','DESC')->get()->toArray();
            $weeklyJobList[$developer->name] = \Task::assignTasks($tasks);
        }
        return view('welcome',["weeklyJobList" => $weeklyJobList]);
    }
}
