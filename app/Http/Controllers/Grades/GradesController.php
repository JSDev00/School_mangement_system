<?php

namespace App\Http\Controllers\Grades;

use App\Models\Grades;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGrades;
use App\Http\Controllers\Controller;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $grades = Grades::all();
        return view('pages.Grades.grade', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrades $request)
    {
        // if (Grades::where('Name->ar', $request->Name)->orWhere('Name->en', $request->Name_en)->exists()) {
        //     return redirect()->back()->withErrors(trans('Grades_trans.exists'));
        // }

        try {
            $validated = $request->validated();
            $Grade = new Grades();
            $Grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
            $Grade->Notes = $request->Notes;
            $Grade->save();
            toastr()->success(trans('messages.saved'));

            return redirect()->route('grades.index');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGrades $request)
    {
        try {
            $validated = $request->validated();
            $Grades = Grades::findOrFail($request->id);
            $Grades->update([
                $Grades->Name = ['en' => $request->Name_en, 'ar' => $request->Name],
                $Grades->Notes = $request->Notes,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('grades.index');

        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $My_ClassId = Classroom::where('Grade_id',$request->id)->pluck('Grade_id');
        if($My_ClassId->count() == 0){
                $Grades = Grades::findOrFail($request->id)->delete();
                toastr()->error(trans('messages.Delete'));
                return redirect()->route('grades.index');

            }else{
                toastr()->error(trans('Grades_trans.delete_Grade_Error'));
                return redirect()->route('grades.index');

        }
    }



}
