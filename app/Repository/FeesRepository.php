<?php

namespace App\Repository;

use App\Models\Fees;
use App\Models\Grades;

class FeesRepository implements FeesRepositoryInterface
{
    public function index()
    {
        $data['fees'] = Fees::all();
        $data['Grades'] = Grades::all();
        return view('pages.Fees.index', $data);
    }

    public function add()
    {

        $data['Grades'] = Grades::all();
        return view('pages.Fees.add', $data);

    }

    public function saveFees($request)
    { try {
        $fees = new Fees();
        $fees->title = ['ar' => $request->title_ar, 'en' => $request->title_en];
        $fees->amount = $request->amount;
        $fees->Grade_id = $request->Grade_id;
        $fees->Classroom_id = $request->Classroom_id;
        $fees->description = $request->description;
        $fees->year = $request->year;
        $fees->Fee_type = $request->Fee_type;
        $fees->save();
        toastr()->success(trans('messages.success'));
        return redirect()->route('Fees.create');
    }

    catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    }

    public function edit($id)
    {
        $fee = Fees::findOrFail($id);
        $Grades = Grades::all();
        return view('pages.Fees.edit', compact('fee', 'Grades'));
    }
    public function update($request)
    {
        try {
            $fees = Fees::findOrFail($request->id);
            $fees->title = ['ar' => $request->title_ar, 'en' => $request->title_en];
            $fees->amount = $request->amount;
            $fees->Grade_id = $request->Grade_id;
            $fees->Classroom_id = $request->Classroom_id;
            $fees->description = $request->description;
            $fees->year = $request->year;
            $fees->Fee_type = $request->Fee_type;
            $fees->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Fees.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function delete($request)
    {
        Fees::destroy($request->id);
        toastr()->success(trans('messages.Delete'));
        return redirect()->back();
    }
}
