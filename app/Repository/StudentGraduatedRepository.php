<?php

namespace App\Repository;
use App\Models\Grades;
use App\Models\Students;

class  StudentGraduatedRepository implements StudentGraduatedRepositoryInterface{
    public function index(){
        $students = Students::onlyTrashed()->get();
        return view('pages.Students.Graduated.index',compact('students'));
    }
    public function create(){
        $Grades = Grades::all();
        return view('pages.Students.Graduated.create',compact('Grades'));
    }
    public function softDelete($request){
        $students = Students::where('Grade_id',$request->Grade_id)->where('classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();
        if($students->count() < 1){
            return redirect()->back()->with('error_Graduated', __('لاتوجد بيانات في جدول الطلاب'));
        }
        foreach($students as $student){
            $ids = explode(',',$student->id);
            $student->whereIn('id',$ids)->Delete();
        }
        toastr()->success(trans('messages.success'));
        return redirect()->route('Graduated.index');
    }
  // ReturnData Students
  public function ReturnData($request){
    Students::onlyTrashed()->where('id',$request->id)->first()->restore();
    toastr()->success(trans('messages.success'));
    return redirect()->back();
  }

  // destroy Students
  public function destroy($request){
    Students::onlyTrashed()->where('id',$request->id)->first()->forceDelete();
    toastr()->success(trans('messages.success'));
    return redirect()->back();
  }

}
