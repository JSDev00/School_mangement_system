<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Students extends Authenticatable
{
    use HasTranslations, SoftDeletes;

    public $translatable = ['name'];
    protected $guraded = [];
    public function gender()
    {
        return $this->belongsTo("App\Models\Gender", "gender_id");
    }

    public function grade()
    {
        return $this->belongsTo("App\Models\Grades", "Grade_id");
    }
    public function classroom()
    {
        return $this->belongsTo("App\Models\Classroom", "classroom_id");
    }
    public function section()
    {
        return $this->belongsTo("App\Models\Sections", "section_id");
    }
    //علاقه بين جدول الطلاب وال صور
    public function images()
    {
        return $this->morphMany("App\Models\Image", "imageable");
    }
    public function Nationality()
    {
        return $this->belongsTo("App\Models\Nationalities", "nationalitie_id");
    }
    public function myparent()
    {
        return $this->belongsTo("App\Models\myParents", "parent_id");
    }
    // علاقة بين جدول سدادت الطلاب وجدول الطلاب لجلب اجمالي المدفوعات والمتبقي
    public function student_account()
    {
        return $this->hasMany('App\Models\StudentAccount', 'student_id');

    }

    // علاقة بين جدول الطلاب وجدول الحضور والغياب
    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance', 'student_id');
    }


}
