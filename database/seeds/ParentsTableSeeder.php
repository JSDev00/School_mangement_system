<?php

use App\Models\Relegion;
use App\Models\myParents;
use App\Models\typeBloods;
use App\Models\Nationalities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('my_parents')->delete();
        $my_parents = new myParents();
        $my_parents->email = 'samir.gamal77@yahoo.com';
        $my_parents->password = Hash::make('12345678');
        $my_parents->Name_Father = ['en' => 'samirgamal', 'ar' => 'سمير جمال'];
        $my_parents->National_ID_Father = '1234567810';
        $my_parents->Passport_ID_Father = '1234567810';
        $my_parents->Phone_Father = '1234567810';
        $my_parents->Job_Father = ['en' => 'programmer', 'ar' => 'مبرمج'];
        $my_parents->Nationality_Father_id = Nationalities::all()->unique()->random()->id;
        $my_parents->Blood_Type_Father_id =typeBloods::all()->unique()->random()->id;
        $my_parents->Religion_Father_id = Relegion::all()->unique()->random()->id;
        $my_parents->Address_Father ='القاهرة';
        $my_parents->Name_Mother = ['en' => 'SS', 'ar' => 'سس'];
        $my_parents->National_ID_Mother = '1234567810';
        $my_parents->Passport_ID_Mother = '1234567810';
        $my_parents->Phone_Mother = '1234567810';
        $my_parents->Job_Mother = ['en' => 'Teacher', 'ar' => 'معلمة'];
        $my_parents->Nationality_Mother_id = Nationalities::all()->unique()->random()->id;
        $my_parents->Blood_Type_Mother_id =typeBloods::all()->unique()->random()->id;
        $my_parents->Religion_Mother_id = Relegion::all()->unique()->random()->id;
        $my_parents->Address_Mother ='القاهرة';
        $my_parents->save();
    }
}
