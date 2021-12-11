@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Student') }}
                    <a href="{{ route('student.index') }}" class="btn btn-primary" style="float: right; margin-left:5px"> Back </a>
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
                    <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group pb-2">
                            <label for="name">Select Teacher Name</label>
                            <select class="form-control" name="teacher">
                            @foreach($teacher as $name)
                                <option   value="{{ $name->id }}">{{ $name->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group pb-2">
                            <label for="name">Student Name</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter Student Name">
                        </div>
                        <div class="form-group pb-2">
                            <label for="image">Select Image</label>
                            <input type="file" class="form-control" name="image" id="image" >
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection