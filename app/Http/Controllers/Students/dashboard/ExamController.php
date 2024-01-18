<?php

namespace App\Http\Controllers\Students\dashboard;

use App\Models\Quizze;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{

    public function index()
    {
        $quizzes = Quizze::where('grade_id', auth()->user()->Grade_id)
        ->where('classroom_id', auth()->user()->classroom_id)
        ->where('section_id', auth()->user()->section_id)
        ->orderBy('id', 'DESC')
        ->get();
    return view('pages.Students.dashboard.exams.index', compact('quizzes'));
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show($quizz_id)
    {
        $student_id = auth()->user()->id;
        return view('pages.Students.dashboard.exams.show',compact('student_id','quizz_id'));
    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
