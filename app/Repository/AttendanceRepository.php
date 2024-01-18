<?php

namespace App\Repository;
use App\Models\Grades;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\Attendance;

class AttendanceRepository implements AttendanceRepositoryInterface{
    public function index(){
        $Grades = Grades::with(['Sections'])->get();
        $teachers = Teachers::all();
        $list_Grades = Grades::all();

        return view('pages.Attendance.Sections',compact('Grades','list_Grades','teachers'));
    }
    public function show($id){
        $students = Students::with('attendance')->where('section_id',$id)->get();
        return view('pages.Attendance.index',compact('students'));

    }
    public function store($request){
        try {

            foreach ($request->attendences as $studentid => $attendence) {

                if( $attendence == 'presence' ) {
                    $attendence_status = true;
                } else if( $attendence == 'absent' ){
                    $attendence_status = false;
                }

                Attendance::create([
                    'student_id'=> $studentid,
                    'grade_id'=> $request->grade_id,
                    'classroom_id'=> $request->classroom_id,
                    'section_id'=> $request->section_id,
                    'teacher_id'=> 1,
                    'attendence_date'=> date('Y-m-d'),
                    'attendence_status'=> $attendence_status
                ]);

            }

            toastr()->success(trans('messages.success'));
            return redirect()->back();

        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function update($request){

    }
    public function delete($request){

    }
}
