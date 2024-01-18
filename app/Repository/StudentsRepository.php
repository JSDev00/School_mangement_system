<?php
namespace App\Repository;

use Exception;
use App\Models\Image;
use App\Models\Gender;
use App\Models\Grades;
use App\Models\Sections;
use App\Models\Students;
use App\Models\Classroom;
use App\Models\myParents;
use App\Models\typeBloods;
use App\Models\Nationalities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;




class StudentsRepository implements StudentsRepositoryInterface
{
    public function createStudent()
    {
        $data['my_classes'] = Grades::all();
        $data['parents'] = myParents::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalities::all();
        $data['bloods'] = typeBloods::all();
        return view('pages.Students.add', $data);
    }
    public function GetClassrooms($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Class_Name", "id");
        return $list_classes;
    }
    public function GetSections($id)
    {
        $list_sections = Sections::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }
    public function CreateStudents($request)
    {
        DB::beginTransaction();

        try {
            $students = new Students();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->classroom_id = $request->classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            if ($request->hasfile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $name = $photo->getClientOriginalName();
                    $photo->storeAs('attachments/students/' . $students->name, $photo->getClientOriginalName(), 'upload_attachments');

                    //insert in database
                    $images = new Image();
                    $images->filename = $name;
                    $images->imageable_id = $students->id;
                    $images->imageable_type = 'App\Models\Students';
                    $images->save();
                }
            }
            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function Get_Students()
    {

        try {
            $students = Students::all();
            return view("pages.Students.index", compact('students'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function Edit_Students($id)
    {
        $data['Grades'] = Grades::all();
        $data['parents'] = myParents::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalities::all();
        $data['bloods'] = typeBloods::all();
        $Students = Students::findOrFail($id);
        return view('pages.Students.edit', $data, compact('Students'));
    }
    public function Update_Student($request)
    {
        try {

            $Edit_Students = Students::findorfail($request->id);
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->email = $request->email;
            $Edit_Students->password = Hash::make($request->password);
            $Edit_Students->gender_id = $request->gender_id;
            $Edit_Students->nationalitie_id = $request->nationalitie_id;
            $Edit_Students->blood_id = $request->blood_id;
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->classroom_id = $request->classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function deleteStudent($request)
    {
        Students::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Students.index');

    }

    public function Show_Student($id){
        try{
            $Student = Students::findOrFail($id);
            return view('pages.Students.show',compact('Student'));
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function Upload_attachment($request){
        try{
            if ($request->hasfile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $name = $photo->getClientOriginalName();
                    $photo->storeAs('attachments/students/' . $request->student_name, $photo->getClientOriginalName(), 'upload_attachments');

                    //insert in database
                    $images = new Image();
                    $images->filename = $name;
                    $images->imageable_id = $request->student_id;
                    $images->imageable_type = 'App\Models\Students';
                    $images->save();
                }
                toastr()->success(trans('messages.success'));
                return redirect()->route('Students.show',$request->student_id);
            }
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }
    public function Download_attachment($studentname,$filename){
        try{
            return response()->download(public_path('attachments/students/'.$studentname.'/'.$filename));
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function Delete_attachment($request){

        try{
            //Delete Image from server
            Storage::disk('upload_attachments')->delete("attachments/students/".$request->student_name.'/'.$request->filename);

            Image::where('id',$request->id)->where('filename',$request->filename)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('Students.show',$request->student_id);
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }
}
