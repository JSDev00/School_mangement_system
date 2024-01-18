<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Requests\StoreClassroom;
use App\Models\Classroom;

use App\Models\Grades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $My_Classes = Classroom::all();
        $Grades = Grades::all();
        return view('pages.My_Classes.My_Classes', compact('My_Classes', 'Grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreClassroom $request)
    {


        $List_classes = $request->List_Classes;

        try {
            $validated = $request->validated();

            foreach ($List_classes as $List_classe) {
                $My_Classroom = new Classroom();
                $My_Classroom->Class_Name = ['ar' => $List_classe['Name'], 'en' => $List_classe['Name_class_en']];
                $My_Classroom->Grade_id = $List_classe['Grade_id'];
                $My_Classroom->save();
            }
            toastr()->success(trans('messages.success'));
            return redirect()->route('Classrooms.index');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
       try {
        $Classrooms = Classroom::findOrFail($request->id);
        $Classrooms->update([
            $Classrooms->Class_Name = ['ar'=>$request->Name,'en'=>$request->Name_en],
            $Classrooms->Grade_id => $request->Grade_id
        ]);
        toastr()->success(trans('messages.Update'));
        return redirect()->route('Classrooms.index');;
       } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request)
    {
            Classroom::findOrFail($request->id)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('Classrooms.index');

    }
    public function delete_all(Request $request)
    {
        // return $request;
        $delete_all_id = explode(",", $request->delete_all_id);
        // dd($delete_all_id);
        Classroom::whereIn('id', $delete_all_id)->Delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Classrooms.index');
    }
    public function Filter_Classes(Request $request)
    {
        $Grades = Grades::all();
        $Search = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        return view('pages.My_Classes.My_Classes',compact('Grades'))->withDetails($Search);

    }

}

?>
