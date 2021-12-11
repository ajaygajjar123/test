<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Address;
use DataTables;
use Validator;
class AddressController extends Controller
{
    public function addresslist(){
        $studentdata = Student::all();
        return view('address.address',compact('studentdata'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  Address::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function (Address $data) {
                return $data->address;    
            })
            ->addColumn('student_name', function (Address $data) {
                return $data->getstudentname->map(function($sub) {
                    return $sub->name;
                })->implode('<br>');
            })
            ->addColumn('action', function($row){
                return '<a href="address/' . $row->id . '/edit" class="btn btn-primary">Edit</a>
                <a href="address/' . $row->id . '/delete" class="btn btn-danger">Delete</a>';
       
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
            'address' => 'required',
            'stud_id' => 'required',
        ]);
     
        if ($validator->passes()) {
            $address = new Address;
            $address->address = $request->address;
            $address->stud_id = $request->stud_id;
            $address->save();
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
        $studentdata = Student::all();
        $address = Address::find($id)->first();
        return view('address.edit',compact('studentdata','address'));
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
            'address' => 'required',
            'stud_id' => 'required'
        ]);
        if ($validator->passes()) {
            $address = Address::find($id);
            $address->address = $request->address;
            $address->stud_id = $request->stud_id;
            $address->update();
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
         $address = Address::findOrFail($id);
        if($address->delete()){
            return redirect()->route('addresslist')->with('message','Address Deleted successfully');
        }else{
            return redirect()->route('addresslist')->with('message','Address Deleted Fails');
        }
    }
}
