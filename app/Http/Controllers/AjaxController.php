<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Models\Classroom;

class AjaxController extends Controller
{
    public function getClassrooms($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Class_Name", "id");
        return $list_classes;
    }

    //Get Sections
    public function Get_Sections($id){

        $list_sections = Sections::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }
}
