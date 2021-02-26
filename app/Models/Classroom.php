<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{

    use HasTranslations;
    public $translatable = ['Name_Class'];
    protected $table = 'classrooms';
    protected $fillable=['Name_Class','Grade_id'];
    public $timestamps = true;

    public function Grades()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }

}
