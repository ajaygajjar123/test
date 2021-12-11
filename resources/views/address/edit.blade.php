@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Address') }}
                    <a href="{{ route('addresslist') }}" class="btn btn-primary" style="float: right; margin-left:5px"> Back </a>
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
                    <div class="alert alert-primary print-sucess-msg" style="display:none"></div>
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <form id="addresseditform">
                         <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Student Name') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="stud_id">
                                    @foreach($studentdata as $value)
                                    @php
                                        $selectvalue = '';
                                    @endphp
                                    @if($value->id == $address->stud_id)
                                        @php    
                                        $selectvalue = 'selected';
                                        @endphp
                                    @endif
                                        <option class="form-control" value="{{ $value->id }}" {{ $selectvalue }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="hobbies" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $address->address }}" autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                            <button type="button" id="studentedit" class="btn btn-primary">Submit</button>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $(document).ready(function(){
        $('#studentedit').click(function(e){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = $('#addresseditform').serialize();
            $.ajax({
                type:'POST',
                processing: true,
                serverSide: true,
                url: "{{ route('address.update',$address->id) }}",
                method: "POST",
                data: form,
                success: function(result){
                    if($.isEmptyObject(result.error)){
                        window.location.href = "{{ route('addresslist') }}";
                    }else{
                        printErrorMsg(result.error);
                    }
                   
                }
            });
        });
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+ value +'</li>');
            });
        }
    });
</script>
@endsection