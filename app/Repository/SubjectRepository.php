<?php

namespace App\Repository;
use App\Models\Grades;
use App\Models\Subject;
use App\Models\Teachers;


class SubjectRepository implements SubjectRepositoryInterface{
    public function index(){
        $subjects = Subject::get();
        return view('pages.Subjects.index',compact('subjects'));
    }
    public function create(){
        $grades = Grades::get();
        $teachers = Teachers::get();
        return view('pages.Subjects.create',compact('grades','teachers'));
    }
    public function edit($id){
        $subject =Subject::findorfail($id);
        $grades = Grades::get();
        $teachers = Teachers::get();
        return view('pages.Subjects.edit',compact('subject','grades','teachers'));
    }
    public function store($request){
        try {
            $subjects = new Subject();
            $subjects->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $subjects->grade_id = $request->Grade_id;
            $subjects->classroom_id = $request->Class_id;
            $subjects->teacher_id = $request->teacher_id;
            $subjects->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('subjects.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function update($request){
        try {
            $subjects =  Subject::findorfail($request->id);
            $subjects->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $subjects->grade_id = $request->Grade_id;
            $subjects->classroom_id = $request->Class_id;
            $subjects->teacher_id = $request->teacher_id;
            $subjects->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('subjects.create');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function destroy($request){
        try {
            Subject::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
