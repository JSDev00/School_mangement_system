<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Students;
use App\Models\Sections;
use App\Models\Attendance;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ids= DB::table('teacher_section')->where('teachers_id',auth()->user()->id)->pluck('sections_id');
        $students = Students::whereIn('section_id',$ids)->get();
        return view('pages.Teachers.dashboard.students.index',compact('students'));
    }

    public function sections(){
        $ids= DB::table('teacher_section')->where('teachers_id',auth()->user()->id)->pluck('sections_id');
        $sections =  Sections::whereIn('id',$ids)->get();
        return view('pages.Teachers.dashboard.sections.index',compact('sections'));

    }
    public function attendance(Request $request)
    {

        try {

            $attenddate = date('Y-m-d');
            foreach ($request->attendences as $studentid => $attendence) {

                if ($attendence == 'presence') {
                    $attendence_status = true;
                } else if ($attendence == 'absent') {
                    $attendence_status = false;
                }

                Attendance::updateOrCreate(['student_id' => $studentid,'attendence_date'=>$attendence],[
                    'student_id' => $studentid,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => auth()->user()->id,
                    'attendence_date' => $attenddate,
                    'attendence_status' => $attendence_status
                ]);
            }
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function editAttendance(Request $request){

        try{
            $date = date('Y-m-d');
            $student_id = Attendance::where('attendence_date',$date)->where('student_id',$request->id)->first();
            if( $request->attendences == 'presence' ) {
                $attendence_status = true;
            } else if( $request->attendences == 'absent' ){
                $attendence_status = false;
            }
            $student_id->update([
                'attendence_status'=> $attendence_status
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function attendence_report(){
        $ids= DB::table('teacher_section')->where('teachers_id',auth()->user()->id)->pluck('sections_id');
        $students = Students::whereIn('section_id',$ids)->get();
        return view('pages.Teachers.dashboard.students.attendence_report',compact('students'));
    }
    public function attendanceSearch(Request $request){

        try{
            $request->validate([
                'from'  =>'required|date|date_format:Y-m-d',
                'to'=> 'required|date|date_format:Y-m-d|after_or_equal:from'
            ],[
                'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
                'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
                'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            ]);



            $ids= DB::table('teacher_section')->where('teachers_id',auth()->user()->id)->pluck('sections_id');
            $students = Students::whereIn('section_id',$ids)->get();

            if($request->student_id == 0){
                $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
                return view('pages.Teachers.dashboard.students.attendence_report',compact('Students','students'));
            }else{
                $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->where('student_id',$request->student_id)->get();
                return view('pages.Teachers.dashboard.students.attendence_report',compact('Students','students'));
            }
        }   catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}