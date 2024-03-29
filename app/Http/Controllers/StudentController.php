<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use DataTables;
use Validator;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data =  Student::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function (Student $data) {
                return $data->name;    
            })
            ->addColumn('phone', function (Student $data) {
                return $data->phone;    
            })
            ->addColumn('email', function (Student $data) {
                return $data->email;    
            })
            ->addColumn('hobbies', function (Student $data) {
                return $data->hobbies;    
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'hobbies' => 'required',
            'email' => 'required|email|unique:student',
        ]);
     
        if ($validator->passes()) {
            $student = new Student;
            $student->name = $request->name;
            $student->phone = $request->phone;
            $student->hobbies = $request->hobbies;
            $student->email = $request->email;
            $student->save();
            return response()->json(['success'=>'Added new records.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
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
        $student = Student::find($id)->first();
        return view('student.edit', compact('student'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'hobbies' => 'required',
            'email' => 'required',
        ]);
        if ($validator->passes()) {
            $student = Student::find($id);
            $student->name = $request->name;
            $student->phone = $request->phone;
            $student->hobbies = $request->hobbies;
            $student->email = $request->email;
            $student->update();
            return response()->json(['success'=>'Records Updated.']);  
            
        }else{
            return response()->json(['error'=>$validator->errors()->all()]); 
        }
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
        if($student->delete()){
            return redirect()->route('home')->with('message','Student Deleted successfully');
        }else{
            return redirect()->route('home')->with('message','Student Deleted Fails');
        }
    }
}
