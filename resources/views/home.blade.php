@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ route('subject.index') }}" class="btn btn-primary">List Subject</a>
                    <a href="{{ route('teacher.index') }}" class="btn btn-primary">List Teacher</a>
                    <a href="{{ route('student.index') }}" class="btn btn-primary">List Student</a>
                    <a href="{{ url('export') }}" class="btn btn-primary">Export</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
