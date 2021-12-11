<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use DataTables;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher.teacher');
    }

    public function teacherdata(Request $request)
    {
        
        $teacherdata = Teacher::select('*');
        return Datatables::of($teacherdata)
        ->addIndexColumn()
        ->addColumn('subjectname', function (Teacher $data) {
            return $data->subjectname->map(function($sub) {
                return $sub->subject;
            })->implode('<br>');
        })
        ->addColumn('action', function($row){
            return '<a href="teacher/' . $row->id . '/edit" class="btn btn-primary">Edit</a>
            <a href="teacher/' . $row->id . '/delete" class="btn btn-danger">Delete</a>';
   
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
        $subject = Subject::select('id','subject')->get();
        return view('teacher.add',compact('subject'));
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
        ]);
        $teacher = Teacher::create([
            'name' => $request->name,
            'sub_id' => $request->subject
        ]);
        if($teacher){
            return redirect()->back()->with('message', 'Teacher Insert Sucessfully');
        }
        return redirect()->back()->with('message', 'Teacher Insert Fail');
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
        $subjectdata = Subject::select('id','subject')->get();
        $teacherdata = Teacher::find($id);
        return view('teacher.edit', compact('teacherdata','subjectdata'));
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
            'name' => 'required'
        ]);

        $teacher = Teacher::find($id)->update([
            'name' => $request->name,
            'sub_id' => $request->subject
        ]);
        return redirect()->route('teacher.index')->with('message','Teacher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res= Teacher::find($id)->delete();
        if ($res){
            return redirect()->route('teacher.index')->with('message','Techer Deleted successfully');
        }else{
            return redirect()->route('teacher.index')->with('message','Teacher Deleted Fails');
        }
    }
}
