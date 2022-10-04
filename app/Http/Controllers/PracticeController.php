<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Practice;

class PracticeController extends Controller
{
    public function sample() {
        return response('練習');
    }

    public function sample2() {
        $test = 'practice2';
        return view('practice2', ['testParam' => $test]);
    }

    public function sample3() {
        return view('practice3', ['testParam' => 'test']);
    }

    public function getPractice()
    {
        $practices = Practice::all();
        return view('getPractice', ['practices' => $practices]);
    }
}
