<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use DataTables;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('subject.subject');
        
    }
    public function data(Request $request)
    {
        
        $data = Subject::select('*');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="subject/' . $row->id . '/edit" class="btn btn-primary">Edit</a>
                    <a href="subject/' . $row->id . '/delete" class="btn btn-danger">Delete</a>';
           
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
        return view('subject.add');
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
            'subject' => 'required',
        ]);
        $subject = Subject::create([
            'subject' => $request->subject
        ]);
        if($subject){
            return redirect()->back()->with('message', 'Subject Insert Sucessfully');
        }
        return redirect()->back()->with('message', 'Subject Insert Fail');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjectdata = Subject::find($id);
        return view('subject.edit', compact('subjectdata'));
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
            'subject' => 'required'
        ]);
        $subject = Subject::find($id)->update($request->all());
        return redirect()->route('subject.index')->with('message','Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res= Subject::find($id)->delete();
        if ($res){
            return redirect()->route('subject.index')->with('message','Subject Deleted successfully');
        }else{
            return redirect()->route('subject.index')->with('message','Subject Deleted Fails');
        }
    }
}
