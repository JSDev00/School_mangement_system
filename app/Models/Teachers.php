<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teachers extends Authenticatable
{
    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded = [];



    //this is about realtionship between genders and teachers
    public function specializations()
    {
        return $this->belongsTo('App\Models\Specialization', 'Specialization_id');
    }
    public function genders()
    {
        return $this->belongsTo('App\Models\Gender', 'Gender_id');
    }
    public function Sections(){
        return $this->belongsToMany('App\Models\Sections','teacher_section');
    }

    public function images(){
        return $this->morphMany("App\Models\Image","imageable");
    }
}
