@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Student') }}
                    <a href="{{ url('/home') }}" class="btn btn-primary" style="float: right; margin-left:5px"> Back </a>
                    <a href="{{ url('/addresslist') }}" class="btn btn-primary" style="float: right; margin-left:5px"> Address List  </a>

                     <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Student</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Student</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="alert alert-primary print-sucess-msg" style="display:none"></div>
                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <form method="POST" action="#" id="studentform">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number') }}</label>

                                            <div class="col-md-6">
                                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus required>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="hobbies" class="col-md-4 col-form-label text-md-right">{{ __('Hobbies') }}</label>

                                            <div class="col-md-6">
                                                <input id="hobbies" type="text" class="form-control @error('hobbies') is-invalid @enderror" name="hobbies" value="{{ old('hobbies') }}" required autocomplete="hobbies" autofocus required>

                                                @error('hobbies')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="studentadd" class="btn btn-primary">Submit</button>
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                              </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive" style="overflow-x: auto">
                    @if (Session::has('message'))
                        <div class="alert alert-success">
                           {{ Session::get('message') }}
                        </div>
                    @endif
                    <table class="table table-bordered studentdata-table w-100 h-100" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Hobbie</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function () {
    var table = $('.studentdata-table').DataTable({
        processing: true,
        serverSide: true,
        bFilter: true,
        bInfo: true,
        ajax: "{{ route('student') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'hobbies', name: 'hobbies'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
  $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#studentadd').click(function(){
            var form = $('#studentform').serialize();
            $.ajax({
                type:'POST',
                processing: true,
                serverSide: true,
                url: "{{ route('student.store') }}",
                method: "POST",
                data: form,
                success: function(result){
                    if($.isEmptyObject(result.error)){
                        console.log(result.success);
                        $(".print-sucess-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $(".print-sucess-msg").html(result.success);
                        $('#studentform')[0].reset();
                    }else{
                        printErrorMsg(result.error);
                    }
                }
               
            });
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-sucess-msg").css('display','none');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+ value +'</li>');
            });
        }
    });
</script>
@endsection
