<?php

use App\Models\Grades;
use App\Models\Sections;
use App\Models\Students;
use App\Models\Classroom;
use App\Models\myParents;
use App\Models\typeBloods;
use App\Models\Nationalities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        $students = new Students();
        $students->name = ['ar' => 'احمد ابراهيم', 'en' => 'Ahmed Ibrahim'];
        $students->email = 'Ahmed_Ibrahim@yahoo.com';
        $students->password = Hash::make('12345678');
        $students->gender_id = 1;
        $students->nationalitie_id = Nationalities::all()->unique()->random()->id;
        $students->blood_id =typeBloods::all()->unique()->random()->id;
        $students->Date_Birth = date('1995-01-01');
        $students->Grade_id = Grades::all()->unique()->random()->id;
        $students->classroom_id =Classroom::all()->unique()->random()->id;
        $students->section_id = Sections::all()->unique()->random()->id;
        $students->parent_id = myParents::all()->unique()->random()->id;
        $students->academic_year ='2021';
        $students->save();
    }
}
