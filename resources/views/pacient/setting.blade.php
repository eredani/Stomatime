@extends('layouts.app')

@section('content')
<div class="container-fluid text-center">
  <br>
        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                        <div class="panel-body">
                               <div class="container">
                                <div class="row my-2">
                                    <div class="col-lg-4 order-lg-1 text-center">
                                            <img id="blah" src="{{ $image }}" class="mx-auto img-fluid img-circle d-block" alt="profil" height="150" width="150">
                                            <h6 class="mt-2">Incarca-ți o imagine de profil</h6>
        
                                            <form method="POST" action="{{route('setprofile')}}" enctype="multipart/form-data">
                                                @csrf
                                                <label for="file-upload" class="custom-file-upload">
                                                    <a class="fa fa-cloud-upload"></a> Custom Upload
                                                </label>
                                                <input type="file" name="profile" id="file-upload" required onchange='document.getElementById("blah").src = window.URL.createObjectURL(this.files[0])'>
                                               
                                                <label for="send" class="custom-file-upload">
                                                    <a class="fa fa-cloud-upload"></a>Save
                                                </label>
                                                <input id="send" type="submit">
                                             </form>
                                            <br><br>
                                        </div>
                                        
                                    <div class="col-lg-8 order-lg-2">
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                                            <h4>{{ $error }}</h4>
                                        </div>
                                        @endforeach
                                        @if(Session::has('success'))
                                        <div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                                            <h4>{{Session::get('success')}}</h4>
                                        </div>
                                    @endif
                                    @if(Session::has('fail'))
                                        <div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert">&times;</a>
                                            <h4>{{Session::get('fail')}}</h4>
                                        </div>
                                    @endif
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="" data-target="#security" data-toggle="tab" class="nav-link active">Securitate</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Profil</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content py-4">
                                            <div class="tab-pane" id="edit">
                                                <form role="form" method="POST" action="{{route('editprofile')}}">
                                                @csrf
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Nume</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="name" type="text" value="{{Auth::user()->name}}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="email" type="email" value="{{Auth::user()->email}}" required>
                                                        </div>
                                                    </div>
                                                    
                                                
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Parola</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="pass" type="password" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Confirmarea Parolei</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="pass1" type="password" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Noua parola (optional)</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="newpass" type="password" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label"></label>
                                                        <div class="col-lg-9">
                                                            <input type="submit" class="btn btn-primary" value="Save Changes">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane active" id="security">

                                                @if (Auth::user()->google2fa_secret)
                                                Dubla autentificare este activată o poți dezactiva apăsând pe butonul de mai jos, dacă faci asta codul din aplicație nu o să mai fie valid.
                                                    <form method="POST" action="{{ route('disabletwoauth') }}">
                                                        {!! csrf_field() !!}
                                                        <input type="submit" class="btn btn-warning" value="Dezactivare">
                                                    </form>
                                                @else
                                                        Deschide-ți aplicația Google Authenticator și scanează codul de mai jos.
                                                        <br/>
                                                        <img alt="Image of QR barcode" src="{{ $QR_Image }}" />
                                                        <br/>
                                                        Daca nu poți să-l scanezi poți copia codul secret:  <code>{{ $secret }}</code> și să îl introduci în aplicație.
                                                        <br /><br />
                                                        <form method="POST" action="{{ route('enabletwoauth') }}">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="secret" value="{{ $secret }}">
                                                            <input type="submit" class="btn btn-success" value="Confirmare">
                                                        </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
</div>
<script>

    window.setTimeout(function () {
        $(".alert-info").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);
</script>
@endsection
