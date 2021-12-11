<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use App\Models\Student;
use DataTables;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.student');
    }
    public function studentdata(Request $request)
    {
        
        $studentdata = Student::select('*');
        return DataTables::of($studentdata)
        ->addIndexColumn()
        ->addColumn('image', function (Student $data) {
            $url = asset('uploads').'/'. $data->image;
            return $url;    
        })
        ->addColumn('teacher', function (Student $data) {
            return $data->getteachername->map(function($sub) {
                return $sub->name;
            })->implode('<br>');
        })
        ->addColumn('action', function($row){
            return '<a href="student/' . $row->id . '/edit" class="btn btn-primary">Edit</a>
            <a href="student/' . $row->id . '/delete" class="btn btn-danger">Delete</a>';
   
        })
        ->rawColumns(['action'])
        ->make(true);
       
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teacher = Teacher::select('id','name','sub_id')->get();
        return view('student.add',compact('teacher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'teacher' =>'required'
        ]);
        $student = new Student;

        if($request->file()) {
            $fileName = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->image->move(public_path('/uploads'), $fileName);

            $student->name = $request->name;
            $student->teach_id = $request->teacher;
            $student->image = $fileName;
            $student->save();

            return view('student.student')->with('message','Student Insert Sucessfully.');
        }
        return view('student.student')->with('message','Student Insert fails.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        $teacherdata = Teacher::all();
        return view('student.edit', compact('student','teacherdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        $student = Student::find($id);

        $student->name = $request->name;
        $student->teach_id = $request->teacher;
        if($request->file()) {
            $fileName = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->image->move(public_path('/uploads'), $fileName);
            $student->image = $fileName;
        }
        if($student->update()){
            return redirect()->route('student.index')->with('message','Student Insert Sucessfully.');    
        }
        return redirect()->route('student.index')->with('message','Student Insert fails.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $image_path = public_path()."/uploads/".$student->image;
    
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        if($student->delete()){
            return redirect()->route('student.index')->with('message','Student Deleted successfully');
        }else{
            return redirect()->route('student.index')->with('message','Student Deleted Fails');
        }
    }

   
}
