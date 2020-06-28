<?php

namespace App\Http\Controllers;

use App\gorevlist;
use Illuminate\Http\Request;

class taskController extends Controller
{
    public function index()
    {
        $data=gorevlist::all();
        return view('tasks',['data'=>$data]);
    }
}
