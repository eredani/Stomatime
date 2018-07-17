@extends('layouts.cabinet')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard Cabinet</div>
            <div class="card-body">
                        @if(Auth::guard('admin')->user())
                        <li class="item">
                            <div class="icon-box">
                                <i class="fa fa-television"></i>
                            </div>
                            <strong>Cabinete</strong>
                            <br>
                            <a href="{{url('cabinet/login')}}">
                                <span>Login | Register</span>
                            </a>
                        </li>
                        @else
                        das
                        @endif
                You are logged in!
            </div>
        </div>
    </div>
</div>
@endsection