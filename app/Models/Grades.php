<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grades extends Model
{
    //
    use HasTranslations;

    public $translatable = ['Name'];
    protected $fillable = ['Name','notes'];
    protected $table = 'Grades';
    public $timestamps = true;

    public function Sections()
    {
        return $this->hasMany('App\Models\Sections', 'Grade_id');
    }
}
