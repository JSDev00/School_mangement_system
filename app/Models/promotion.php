<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promotion extends Model
{
    protected $fillable = ['student_id','from_grade','from_classroom','from_section','to_grade','to_classroom','to_section','academic_year','academic_year_new'];


    public function student(){
        return $this->belongsTo("App\Models\Students","student_id");
    }
    public function f_grade(){
        return $this->belongsTo("App\Models\Grades","from_grade");
    }
    public function f_classroom(){
        return $this->belongsTo("App\Models\Classroom","from_classroom");
    }
    public function f_section(){
        return $this->belongsTo("App\Models\Sections","from_section");
    }
    public function t_grade(){
        return $this->belongsTo("App\Models\Grades","to_grade");
    }
    public function t_classroom(){
        return $this->belongsTo("App\Models\Classroom","to_classroom");
    }
    public function t_section(){
        return $this->belongsTo("App\Models\Sections","to_section");
    }

}
