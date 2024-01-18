<?php

use App\Models\typeBloods;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class typeBloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_bloods')->delete();
        $blods = ['O-','O+','A+','A-','AB-','AB+','B+','B-'];
        foreach($blods as $blod){
            typeBloods::create(['Name'=>$blod]);
        }

    }
}
