<?php

namespace App\Models;
use App\Models\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = "teacher";
    protected $fillable = [
        'name','sub_id'
    ];

    public function subjectname(){
        return $this->hasMany(Subject::class ,'id','sub_id');
    }
}
