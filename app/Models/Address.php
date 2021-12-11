<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Address extends Model
{
    use HasFactory;
     protected $table = "address";
    protected $fillable =[
        'address','stu_id'
    ];

    public function getstudentname(){
    	return $this->hasMany(Student::class,'id','stud_id');
    }
}
