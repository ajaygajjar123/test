@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Bussiness') }}
                    <a href="{{ route('teacher.index') }}" class="btn btn-primary" style="float: right; margin-left:5px"> Back </a>
                </div>
                <div class="card-body">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-success" role="alert">
                        {{ $error }}
                    </div>
                    @endforeach

                    @if (Session::has('message'))
                        <div class="alert alert-success">
                           {{ Session::get('message') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('teacher.update',$teacherdata->id) }}">
                        @csrf
                        @method("PUT")
                        <div class="form-group pb-2">
                            <select class="form-control" name="subject">
                            @foreach($subjectdata as $name)
                                @php
                                    $selectvalue = '';
                                @endphp
                                @if($name->id == $teacherdata->sub_id)
                                    @php    
                                    $selectvalue = 'selected';
                                    @endphp
                                @endif
                                <option   value="{{ $name->id }}" {{ $selectvalue }}>{{ $name->subject }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group pb-2">
                            <label for="name">Teacher Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $teacherdata->name }}" id="name" aria-describedby="nameHelp" placeholder="Enter Teahcer Name">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection