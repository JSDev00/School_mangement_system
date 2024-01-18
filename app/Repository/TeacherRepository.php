<?php
namespace App\Repository;

use App\Models\Gender;
use App\Models\Teachers;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function getAllTeachers()
    {
        return Teachers::all();
    }

    public function getSpecialization()
    {

        return Specialization::all();
    }

    public function getGender()
    {
        return Gender::all();

    }

    public function StoreTeachers($request)
    {
        try {
            $Teacher = new Teachers();
            $Teacher->email = $request->Email;
            $Teacher->name = ['ar' => $request->Name_ar, 'en' => $request->Name_en];
            $Teacher->password = Hash::make($request->Password);
            $Teacher->Specialization_id = $request->Specialization_id;
            $Teacher->Gender_id = $request->Gender_id;
            $Teacher->Joining_Date = $request->Joining_Date;
            $Teacher->Address = $request->Address;
            $Teacher->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Teachers.index');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function editTeachers($id){

        try{
           $Teachers =  Teachers::findOrFail($id);
           $specializations  = $this->getSpecialization();
           $genders = $this->getGender();
           return view('pages.Teachers.edit',compact('Teachers','specializations','genders'));
        }catch(Exception $e){
            return redirect()->back()->withError(['error'=>$e->getMessage()]);
        }
    }
    public function updateTeachers($request){
        try {
            $Teachers = Teachers::findOrFail($request->id);
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);
            $Teachers->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Teachers.index');
        }catch(Exception $e){
            return redirect()->back()->withError(['error'=>$e->getMessage()]);
        }
    }
    public function deleteTeachers($request){
        Teachers::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Teachers.index');
    }
}
