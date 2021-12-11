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

                     <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Address</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="alert alert-primary print-sucess-msg" style="display:none"></div>
                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                        <ul></ul>
                                    </div>
                                    <form id="addressform">
                                         <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>

                                            <div class="col-md-6">
                                                <select class="form-control" name="stud_id">
                                                    @foreach($studentdata as $value)
                                                        <option class="form-control" value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="hobbies" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address" autofocus>

                                                @error('address')
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

                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success">
                           {{ Session::get('message') }}
                        </div>
                    @endif
                    <table class="table table-bordered address-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Student</th>
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
        var table = $('.address-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('address') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'student_name', name: 'student_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }); 
  $(document).ready(function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#studentadd').click(function(){
            var form = $('#addressform').serialize();
            $.ajax({
                type:'POST',
                processing: true,
                serverSide: true,
                url: "{{ route('address.store') }}",
                method: "POST",
                data: form,
                success: function(result){
                    if($.isEmptyObject(result.error)){
                        $(".print-sucess-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $(".print-sucess-msg").html(result.success);
                        $('#addressform')[0].reset();
                    }else{
                        printErrorMsg(result.error);
                    }
                }
               
            });
        });

        function printErrorMsg (msg) {
            $(".print-sucess-msg").css('display','none');
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+ value +'</li>');
            });
        }
    });
</script>
@endsection
