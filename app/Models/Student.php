<?php

namespace App\Models;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = "student";
    protected $fillable =[
        'name','image','teach_id'
    ];

    public function getteachername(){
        return $this->hasMany(Teacher::class,'id','teach_id');
    }
}
