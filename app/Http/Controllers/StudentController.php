<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Euclidean;
use NaiveBayes;

class StudentController extends Controller
{
    /**
     * Show the campus form.
     */
    public function campus()
    {
        return view('/campus');
    }

    /**
     * Show the gender form.
     */
    public function gender()
    {
        return view('/gender');
    }

    /**
     * Get the campus name for the campus form.
     * 
     * @param Request $request.
     * @return string Campus name.
     */
    public function getCampus(Request $request)
    {
        $students = DB::table('students')->select('style', 'average', 'gender', 'campus')->get();
        $min = 1000;

        $style = $request->input('style');
        $average = $request->input('average');
        $gender = $request->input('gender');
        $algorithm = $request->input('algorithm');

        $vectorX = [$style, $average, $gender];

        if (strcmp($algorithm, "nbayes") == 0)
            return NaiveBayes::nBayes($students, 'campus', $vectorX, 'students');
        else
            return Euclidean::euclidean($vectorX, $students);
    }

    /**
     * Get the gender for the gender form.
     * 
     * @param Request $request.
     * @return string Gender.
     */
    public function getGender(Request $request)
    {
        $students = DB::table('students')->select('style', 'campus', 'average', 'gender')->get();
        $min = 1000;

        $style = $request->input('style');
        $campus = $request->input('campus');
        $average = $request->input('average');
        $algorithm = $request->input('algorithm');

        $vectorX = [$style, $campus, $average];

        if (strcmp($algorithm, "nbayes") == 0)
            $gender = NaiveBayes::nBayes($students, 'gender', $vectorX, 'students');
        else
            $gender = Euclidean::euclidean($vectorX, $students);

        return ($gender == "M")? "Masculino": "Femenino";
    }
}
