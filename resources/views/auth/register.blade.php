@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Înregistrare') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
 
                            <label for="name" class="col-md-4 control-label">Register With</label>

                            <div class="col-md-6">

                                <a href="{{ url('login/facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>

                                <a href="{{ url('login/twitter') }}" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>

                                <a href="{{ url('login/google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i></a>

                                <a href="{{ url('login/linkedin') }}" class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>

                                <a href="{{ url('login/github') }}" class="btn btn-social-icon btn-github"><i class="fa fa-github"></i></a>

                                <a href="{{ url('login/bitbucket') }}" class="btn btn-social-icon btn-bitbucket"><i class="fa fa-bitbucket"></i></a>

                            </div>

                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
 
 <label for="name" class="col-md-4 control-label">Nume</label>

 <div class="col-md-6">

 @if(!empty($name))

     <input id="name" type="text" class="form-control" name="name" value="{{$name}}" required autofocus>

 @else

     <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

 @endif    

     @if ($errors->has('name'))

         <span class="help-block">

             <strong>{{ $errors->first('name') }}</strong>

         </span>

     @endif

 </div>

</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

 <label for="email" class="col-md-4 control-label">Email</label>

 <div class="col-md-6">

     @if(!empty($email))

     <input id="email" type="email" class="form-control" name="email" value="{{$email}}" required>

     @else

     <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

     @endif

     @if ($errors->has('email'))

         <span class="help-block">

             <strong>{{ $errors->first('email') }}</strong>

         </span>

     @endif

 </div>

</div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Parola') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Parola') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        {!! app('captcha')->render(); !!}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Înregistrare') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
