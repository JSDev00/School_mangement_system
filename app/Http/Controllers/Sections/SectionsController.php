<?php

namespace App\Http\Controllers\Sections;

use App\Models\Grades;
use App\Models\Sections;
use App\Models\Classroom;
use App\Models\Teachers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSection;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Grades = Grades::with(['Sections'])->get();
        $list_Grades = Grades::all();
        $teachers = Teachers::all();
        return view('pages.Sections.sections', compact('list_Grades', 'Grades', 'teachers'));
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
    public function store(StoreSection $request)
    {
        try {
            $validated = $request->validated();
            $Sections = new Sections();
            $Sections->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $Sections->Grade_id = $request->Grade_id;
            $Sections->Class_id = $request->Class_id;
            $Sections->Status = 1;
            // This is about Realtionship Many to many
            $Sections->save();
            $Sections->Teachers()->attach($request->teacher_id);
            toastr()->success(trans('messages.saved'));

            return redirect()->route('Sections.index');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSection $request)
    {
        try {
            $validated = $request->validated();

            $section = Sections::findOrFail($request->id);

            $section->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_Ar];
            $section->Grade_id = $request->Grade_id;
            $section->Class_id = $request->Class_id;
            if (isset($request->Status)) {
                $section->Status = 1;
            } else {
                $section->Status = 2;

            }

            if (isset($request->teacher_id)) {
                $section->Teachers()->sync($request->teacher_id);
            } else {
                $section->Teachers()->sync(array());
            }
            $section->save();
            toastr()->success(trans('messages.saved'));

            return redirect()->route('Sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Sections::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Sections.index');
    }
    public function getclasses($id)
    {
        $list_Classes = Classroom::where('Grade_id', $id)->pluck('Class_Name', 'id');
        return $list_Classes;
    }
}
