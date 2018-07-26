@extends('layouts.cabinet')

@section('content')
<div class="container-fluid">

        <div class="row">
            <div class="col">
                <div class="panel panel-default">
                        <div class="panel-body">
                               <div class="container-fluid">
                                <div class="row my-2">
                                    <div class="col-lg-3 order-lg-1 text-center">
                                    <img id="blah" src="{{ $image }}" class="mx-auto img-fluid img-circle d-block" alt="profil" height="150" width="150">
                                            <h6 class="mt-2">Incarca-ți propriul logo.</h6>
        
                                            <form method="POST" action="{{route('cabinet.setprofile')}}" enctype="multipart/form-data">
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
                                    <div class="col-lg-4 order-lg-2 text-center">
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
                                                <a href="" data-target="#publicprofile" data-toggle="tab" class="nav-link active">Profil Public</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Cont</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content py-4">
                                            <div class="tab-pane " id="edit">
                                                <form role="form" method="POST" action="{{route('cabinet.editprofile')}}">
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
                                                        <div class="col-lg-2">
                                                            <input type="submit" class="btn btn-primary" value="Salvează">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane active" id="publicprofile">
                                            <p>Tot ce se completează aici o sa fie vizibil catre toti oamenii care folosesc aplicația Stomatime.</p>
                                            <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Descriere</label>
                                                        <div class="col-lg-9">
                                                            <textarea class="form-control" name="descriere" type="textarea" form="setprofile" >{{Auth::user()->descriere}}</textarea>
                                                        </div>
                                                    </div>
                                            <form role="form" method="POST" id="setprofile" action="{{route('cabinet.setpublicprofile')}}">
                                                @csrf                                                                     
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Slogan</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="slogan" type="text" value="{{Auth::user()->moto}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Număr</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="numar" type="number" value="{{Auth::user()->numar}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Adresa</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control" name="adresa" id="adresa" type="text" readonly value="{{Auth::user()->adresa}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 control-label">Program</label>
                                                        <div class="col-lg-3">
                                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#program">Setează Programul</button>
                                                            <div class="modal fade" id="program" role="dialog">
                                                                <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Setează programul cabinetului.</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="lunird()" id="luniS">
                                                                                    Luni
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Lstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startL" data-toggle="datetimepicker" data-target="#Lstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#Lstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Lstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopL"  placeholder="Stop" data-target="#Lstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#Lstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="martird()" id="martiS">
                                                                                    Marți
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="MAstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startMA" data-toggle="datetimepicker" data-target="#MAstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#MAstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="MAstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopMA" placeholder="Stop" data-target="#MAstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#MAstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="miercurird()" id="miercuriS">
                                                                                    Miercuri
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="MIstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startMI" data-toggle="datetimepicker" data-target="#MIstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#MIstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="MIstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopMI" placeholder="Stop" data-target="#MIstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#MIstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="joird()" id="joiS">
                                                                                    Joi
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Jstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startJ" data-toggle="datetimepicker" data-target="#Jstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#Jstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Jstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopJ" placeholder="Stop" data-target="#Jstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#Jstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="vinerird()" id="vineriS">
                                                                                    Vineri
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Vstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startV" data-toggle="datetimepicker" data-target="#Vstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#Vstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Vstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopV" placeholder="Stop" data-target="#Vstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#Vstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="sambatard()" id="sambataS">
                                                                                    Sâmbătă
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Sstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startS" data-toggle="datetimepicker" data-target="#Sstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#Sstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Sstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopS" placeholder="Stop" data-target="#Sstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#Sstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                            <div class="form-check">
                                                                                <center><label class="form-check-label">
                                                                                    <input form="setprofile" class="form-check-input" type="checkbox" onclick="duminicard()" id="duminicaS">
                                                                                    Duminică
                                                                                    </label>
                                                                                </center>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Dstart" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startD" data-toggle="datetimepicker" data-target="#Dstart" readonly/>
                                                                                        <div class="input-group-append" data-target="#Dstart"  data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="input-group date" id="Dstop" data-target-input="nearest">
                                                                                        <input form="setprofile" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopD" placeholder="Stop" data-target="#Dstop" readonly/>
                                                                                        <div class="input-group-append" data-target="#Dstop" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Public</label>
                                                        <div class="col-lg-2">

                                                            <label class="switch">
                                                                <input type="checkbox" name="public" value="1" @if(Auth::user()->public) checked  @endif>
                                                                <span class="slider round"></span>
                                                            </label>



                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input type="submit" class="btn btn-primary" value="Salvează">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-9">
                                                            <input class="form-control" type="hidden" name="long" id="long" value="{{Auth::user()->long}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        
                                                        <div class="col-lg-9">
                                                        <input class="form-control" type="hidden" name="lat" id="lat" value="{{Auth::user()->lat}}" required>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 order-lg-3">
                                        <div id="map" style="width:100%;height:400px;">

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
    $(document).ready(function() {

        var array = {!! Auth::user()->program !!};
        if(array['luni']!=null)
        {
        document.getElementById("luniS").checked=true;
        document.getElementById("startL").readOnly = false;
        document.getElementById("stopL").readOnly = false;
   
        document.getElementById("stopL").required = true;
        document.getElementById("startL").required = true;

         document.getElementById("startL").value = array['luni']['start'];
        document.getElementById("stopL").value = array['luni']['stop'];
   
   
        document.getElementById("startL").setAttribute("name", "program[luni][start]");
        document.getElementById("stopL").setAttribute("name", "program[luni][stop]");
        }
        if(array['marti']!=null)
        {
            document.getElementById("martiS").checked=true;
        document.getElementById("startMA").readOnly = false;
        document.getElementById("stopMA").readOnly = false;
   
        document.getElementById("stopMA").required = true;
        document.getElementById("startMA").required = true;
   
        document.getElementById("stopMA").value = array['marti']['stop'];
        document.getElementById("startMA").value = array['marti']['start'];

        document.getElementById("startMA").setAttribute("name", "program[marti][start]");
        document.getElementById("stopMA").setAttribute("name", "program[marti][stop]");
        }
        if(array['miercuri']!=null)
        {
            document.getElementById("miercuriS").checked=true;
            document.getElementById("startMI").readOnly = false;
           document.getElementById("stopMI").readOnly = false;
           document.getElementById("stopMI").required = true;
           document.getElementById("startMI").required = true;

            document.getElementById("stopMI").value = array['miercuri']['stop'];
            document.getElementById("startMI").value = array['miercuri']['start'];

           document.getElementById("startMI").setAttribute("name", "program[miercuri][start]");
           document.getElementById("stopMI").setAttribute("name", "program[miercuri][stop]");

        }
        if(array['joi']!=null)
        {
            document.getElementById("joiS").checked=true;
            document.getElementById("startJ").readOnly = false;
           document.getElementById("stopJ").readOnly = false;
           document.getElementById("stopJ").required = true;
           document.getElementById("startJ").required = true;
           document.getElementById("startJ").setAttribute("name", "program[joi][start]");
           document.getElementById("stopJ").setAttribute("name", "program[joi][stop]");
           document.getElementById("stopJ").value = array['joi']['stop'];
            document.getElementById("startJ").value = array['joi']['start'];
        }
        if(array['vineri']!=null)
        {
            document.getElementById("vineriS").checked=true;
            document.getElementById("startV").readOnly = false;
            document.getElementById("stopV").readOnly = false;
            document.getElementById("stopV").required = true;
            document.getElementById("startV").required = true;
            document.getElementById("startV").setAttribute("name", "program[vineri][start]");
            document.getElementById("stopV").setAttribute("name", "program[vineri][stop]");
            document.getElementById("stopV").value = array['vineri']['stop'];
                document.getElementById("startV").value = array['vineri']['start'];
        }
        if(array['sambata']!=null)
        {
            document.getElementById("sambataS").checked=true;
            document.getElementById("startS").readOnly = false;
            document.getElementById("stopS").readOnly = false;
            document.getElementById("stopS").required = true;
            document.getElementById("startS").required = true;
            document.getElementById("startS").setAttribute("name", "program[sambata][start]");
            document.getElementById("stopS").setAttribute("name", "program[sambata][stop]");
            document.getElementById("stopS").value = array['sambata']['stop'];
                document.getElementById("startS").value = array['sambata']['start'];
        }
        if(array['duminica']!=null)
        {
            document.getElementById("duminicaS").checked=true;
            document.getElementById("startD").readOnly = false;
            document.getElementById("stopD").readOnly = false;
            document.getElementById("stopD").required = true;
            document.getElementById("startD").required = true;
            document.getElementById("startD").setAttribute("name", "program[duminica][start]");
            document.getElementById("stopD").setAttribute("name", "program[duminica][stop]");
            document.getElementById("stopD").value = array['duminica']['stop'];
                document.getElementById("startD").value = array['duminica']['start'];
        }
      
    });
</script>
<script>
    var marker;
    var infowindow;
  
    function myMap() 
    {
        
        var mapCanvas = document.getElementById("map");
    
        if(document.getElementById("long").value=="" || document.getElementById("lat").value=="")
        {
            var myCenter=new google.maps.LatLng(45.9432,24.9668);
            var mapOptions = {center: myCenter, zoom: 11};
            var map = new google.maps.Map(mapCanvas, mapOptions);
            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(map, event.latLng);
            });
            placeMarker(map, myCenter);
        }
        else
        {
            var myCenter=new google.maps.LatLng(document.getElementById("lat").value,document.getElementById("long").value);
            var mapOptions = {center: myCenter, zoom: 11};
            var map = new google.maps.Map(mapCanvas, mapOptions);
            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(map, event.latLng);
            });
            placeMarker(map, myCenter);
        }
    }

    function placeMarker(map, location) {
    if (!marker || !marker.setPosition) {
        var geocoder = new google.maps.Geocoder;
        geocoder.geocode({'location': location}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(11);
               marker = new google.maps.Marker({
                position: location,
                map: map
              });
              infowindow.setContent(results[0].formatted_address);
              document.getElementById("adresa").value = results[0].formatted_address;
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
    } else {
        var geocoder = new google.maps.Geocoder;
        geocoder.geocode({'location': location}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(11);
              marker.setPosition(location);
              infowindow.setContent(results[0].formatted_address);
              document.getElementById("adresa").value = results[0].formatted_address;
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
    }
    if (!!infowindow && !!infowindow.close) {
        infowindow.close();
    }
    infowindow = new google.maps.InfoWindow();
    infowindow.open(map, marker);
    document.getElementById("lat").value =location.lat();
    document.getElementById("long").value =location.lng()
    }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgvKK8zIvqhXuGnv9uYbiIT_biwXPg4YM&callback=myMap"></script>
<script>
        $("#imgInp").change(function(){
            readURL(this);
        });
        window.setTimeout(function () {
            $(".alert-info").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2000);
</script>
<script>
   $(function() {
       $('#Lstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#Lstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#Lstart").on("change.datetimepicker", function(e) {
           $('#Lstop').datetimepicker('minDate', e.date);
       });
       $("#Lstop").on("change.datetimepicker", function(e) {
           $('#Lstart').datetimepicker('maxDate', e.date);
       });
   
       $('#MAstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#MAstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#MAstart").on("change.datetimepicker", function(e) {
           $('#MAstop').datetimepicker('minDate', e.date);
       });
       $("#MAstop").on("change.datetimepicker", function(e) {
           $('#MAstart').datetimepicker('maxDate', e.date);
       });
   
       $('#MIstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#MIstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#MIstart").on("change.datetimepicker", function(e) {
           $('#MIstop').datetimepicker('minDate', e.date);
       });
       $("#MIstop").on("change.datetimepicker", function(e) {
           $('#MIstart').datetimepicker('maxDate', e.date);
       });
   
       $('#Jstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#Jstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#Jstart").on("change.datetimepicker", function(e) {
           $('#Jstop').datetimepicker('minDate', e.date);
       });
       $("#Jstop").on("change.datetimepicker", function(e) {
           $('#Jstart').datetimepicker('maxDate', e.date);
       });
   
       $('#Vstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#Vstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#Vstart").on("change.datetimepicker", function(e) {
           $('#Vstop').datetimepicker('minDate', e.date);
       });
       $("#Vstop").on("change.datetimepicker", function(e) {
           $('#Vstart').datetimepicker('maxDate', e.date);
       });
   
       $('#Sstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#Sstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#Sstart").on("change.datetimepicker", function(e) {
           $('#Sstop').datetimepicker('minDate', e.date);
       });
       $("#Sstop").on("change.datetimepicker", function(e) {
           $('#Sstart').datetimepicker('maxDate', e.date);
       });
   
       $('#Dstart').datetimepicker({
           format: 'HH:mm'
       });
       $('#Dstop').datetimepicker({
           format: 'HH:mm'
       });
       $("#Dstart").on("change.datetimepicker", function(e) {
           $('#Dstop').datetimepicker('minDate', e.date);
       });
       $("#Dstop").on("change.datetimepicker", function(e) {
           $('#Dstart').datetimepicker('maxDate', e.date);
       });
   });
   
   function lunird() {
       var cb = document.getElementById("luniS");
       if (cb.checked == true) {
           document.getElementById("startL").readOnly = false;
           document.getElementById("stopL").readOnly = false;
   
           document.getElementById("stopL").required = true;
           document.getElementById("startL").required = true;
   
           document.getElementById("startL").setAttribute("name", "program[luni][start]");
           document.getElementById("stopL").setAttribute("name", "program[luni][stop]");
       } else {
           document.getElementById("startL").readOnly = true;
           document.getElementById("stopL").readOnly = true;
   
           document.getElementById("stopL").required = false;
           document.getElementById("startL").required = false;
   
           document.getElementById("startL").removeAttribute("name");
           document.getElementById("stopL").removeAttribute("name");
       }
   }
   
   function martird() {
       var cb = document.getElementById("martiS");
       if (cb.checked == true) {
           document.getElementById("startMA").readOnly = false;
           document.getElementById("stopMA").readOnly = false;
   
           document.getElementById("stopMA").required = true;
           document.getElementById("startMA").required = true;
   
           document.getElementById("startMA").setAttribute("name", "program[marti][start]");
           document.getElementById("stopMA").setAttribute("name", "program[marti][stop]");
       } else {
           document.getElementById("startMA").readOnly = true;
           document.getElementById("stopMA").readOnly = true;
   
           document.getElementById("startMA").required = false;
           document.getElementById("stopMA").required = false;
   
           document.getElementById("startMA").removeAttribute("name");
           document.getElementById("stopMA").removeAttribute("name");
       }
   }
   
   function miercurird() {
       var cb = document.getElementById("miercuriS");
       if (cb.checked == true) {
           document.getElementById("startMI").readOnly = false;
           document.getElementById("stopMI").readOnly = false;
           document.getElementById("stopMI").required = true;
           document.getElementById("startMI").required = true;
           document.getElementById("startMI").setAttribute("name", "program[miercuri][start]");
           document.getElementById("stopMI").setAttribute("name", "program[miercuri][stop]");
       } else {
           document.getElementById("startMI").readOnly = true;
           document.getElementById("stopMI").readOnly = true;
           document.getElementById("stopMI").required = false;
           document.getElementById("startMI").required = false;
           document.getElementById("startMI").removeAttribute("name");
           document.getElementById("stopMI").removeAttribute("name");
       }
   }
   
   function joird() {
       var cb = document.getElementById("joiS");
       if (cb.checked == true) {
           document.getElementById("startJ").readOnly = false;
           document.getElementById("stopJ").readOnly = false;
           document.getElementById("stopJ").required = true;
           document.getElementById("startJ").required = true;
           document.getElementById("startJ").setAttribute("name", "program[joi][start]");
           document.getElementById("stopJ").setAttribute("name", "program[joi][stop]");
       } else {
           document.getElementById("startJ").readOnly = true;
           document.getElementById("stopJ").readOnly = true;
           document.getElementById("stopJ").required = false;
           document.getElementById("startJ").required = false;
           document.getElementById("startJ").removeAttribute("name");
           document.getElementById("stopJ").removeAttribute("name");
       }
   }
   
   function vinerird() {
       var cb = document.getElementById("vineriS");
       if (cb.checked == true) {
           document.getElementById("startV").readOnly = false;
           document.getElementById("stopV").readOnly = false;
           document.getElementById("stopV").required = true;
           document.getElementById("startV").required = true;
           document.getElementById("startV").setAttribute("name", "program[vineri][start]");
           document.getElementById("stopV").setAttribute("name", "program[vineri][stop]");
       } else {
           document.getElementById("startV").readOnly = true;
           document.getElementById("stopV").readOnly = true;
           document.getElementById("stopV").required = false;
           document.getElementById("startV").required = false;
           document.getElementById("startV").removeAttribute("name");
           document.getElementById("stopV").removeAttribute("name");
       }
   }
   
   function sambatard() {
       var cb = document.getElementById("sambataS");
       if (cb.checked == true) {
           document.getElementById("startS").readOnly = false;
           document.getElementById("stopS").readOnly = false;
           document.getElementById("stopS").required = true;
           document.getElementById("startS").required = true;
           document.getElementById("startS").setAttribute("name", "program[sambata][start]");
           document.getElementById("stopS").setAttribute("name", "program[sambata][stop]");
       } else {
           document.getElementById("startS").readOnly = true;
           document.getElementById("stopS").readOnly = true;
           document.getElementById("stopS").required = false;
           document.getElementById("startS").required = false;
           document.getElementById("startS").removeAttribute("name");
           document.getElementById("stopS").removeAttribute("name");
       }
   }
   
   function duminicard() {
       var cb = document.getElementById("duminicaS");
       if (cb.checked == true) {
           document.getElementById("startD").readOnly = false;
           document.getElementById("stopD").readOnly = false;
           document.getElementById("stopD").required = true;
           document.getElementById("startD").required = true;
           document.getElementById("startD").setAttribute("name", "program[duminica][start]");
           document.getElementById("stopD").setAttribute("name", "program[duminica][stop]");
       } else {
           document.getElementById("startD").readOnly = true;
           document.getElementById("stopD").readOnly = true;
           document.getElementById("stopD").required = false;
           document.getElementById("startD").required = false;
           document.getElementById("startD").removeAttribute("name");
           document.getElementById("stopD").removeAttribute("name");
       }
   }
</script>
@endsection
