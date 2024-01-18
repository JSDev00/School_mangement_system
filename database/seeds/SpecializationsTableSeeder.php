<?php

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("specializations")->delete();

        $specializations = [
            ['en'=> 'Arabic', 'ar'=>'عربي'],
            ['en'=> 'Science', 'ar'=>'علوم'],
            ['en'=> 'Computer', 'ar'=>'حاسب الى'],
            ['en'=> 'English', 'ar'=>'انجليزي'],
        ];
        foreach($specializations as $s){
            Specialization::create(['Name'=>$s]);
        }
    }
}
