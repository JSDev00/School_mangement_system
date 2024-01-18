<?php

namespace App\Repository;

use App\Models\Grades;
use App\Models\Students;
use App\Models\promotion;
use Illuminate\Support\Facades\DB;


class StudentsRepositoryPromotions implements StudentsRepositoryPromotionsInterface
{
    public function index()
    {
        $data['Grades'] = Grades::all();
        return view('pages.Students.promotions.index', $data);
    }
    public function create()
    {
        $promotions = promotion::all();
        return view('pages.Students.promotions.mangement', compact('promotions'));

    }
    public function store($request)
    {
        // DB::beginTransaction();

        try {
            $students = Students::where('Grade_id', $request->Grade_id)->where('classroom_id', $request->Classroom_id)->where('section_id', $request->section_id)->where('academic_year', $request->academic_year)->get();

            if ($students->count() < 1) {
                return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
            }

            // update in table student
            foreach ($students as $student) {

                $ids = explode(',', $student->id);
                Students::whereIn('id', $ids)
                    ->update([
                        'Grade_id' => $request->Grade_id_new,
                        'classroom_id' => $request->Classroom_id_new,
                        'section_id' => $request->section_id_new,
                        'academic_year' => $request->academic_year_new,
                    ]);

                // insert in to promotions
                promotion::updateOrCreate([
                    'student_id' => $student->id,
                    'from_grade' => $request->Grade_id,
                    'from_classroom' => $request->Classroom_id,
                    'from_section' => $request->section_id,
                    'to_grade' => $request->Grade_id_new,
                    'to_classroom' => $request->Classroom_id_new,
                    'to_section' => $request->section_id_new,
                    'academic_year' => $request->academic_year,
                    'academic_year_new' => $request->academic_year_new,
                ]);
            }
            // insert in to promotions
// $promotion = new promotion();
// $promotion->student_id = $student->id;
// $promotion->from_grade = $request->Grade_id;
// $promotion->from_classroom = $request->Classroom_id;
// $promotion->from_section = $request->section_id;
// $promotion->to_grade = $request->Grade_id_new;
// $promotion->to_classroom = $request->Classroom_id_new;
// $promotion->to_section = $request->section_id_new;
// $promotion->save();

            // DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->back();

        } catch (\Exception $e) {
            // DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function destroy($request)
    {
        DB::beginTransaction();

        try{
            if ($request->page_id == 1) {
                $Promotions = promotion::all();
                foreach ($Promotions as $promotion) {
                    $ids = explode(',', $promotion->student_id);
                    Students::whereIn('id', $ids)
                        ->update([
                            'Grade_id' => $promotion->from_grade,
                            'classroom_id' => $promotion->from_classroom,
                            'section_id' => $promotion->from_section,
                            'academic_year' => $promotion->academic_year,
                        ]);
                        promotion::truncate();
                    }
                    DB::commit();
                    toastr()->error(trans('messages.Delete'));
                    return redirect()->back();
            }

            else{
                $promotion = promotion::findOrFail($request->id);
                Students::where('id', $promotion->student_id)
                ->update([
                    'Grade_id' => $promotion->from_grade,
                    'classroom_id' => $promotion->from_classroom,
                    'section_id' => $promotion->from_section,
                    'academic_year' => $promotion->academic_year,
                ]);
                promotion::destroy($request->id);
                DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
