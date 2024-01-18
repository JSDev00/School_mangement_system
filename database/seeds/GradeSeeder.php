<?php

use App\Models\Grades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("Grades")->delete();

        $Grades = [
            ['en'=>'PrimaryStage','ar'=>'المرحله الابتدائيه'],
            ['en'=>'MiddleStage','ar'=>'المرحله الاعداديه'],
            ['en'=>'SeondaryStage','ar'=>'المرحله الثانويه'],
        ];
        foreach($Grades as $grade){
            Grades::create(['Name'=>$grade]);
        }
    }
}
