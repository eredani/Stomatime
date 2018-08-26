@extends('layouts.cabinet')
@section('content')
@include('layouts.script')
<ul class="nav nav-tabs">
   <li class="nav-item">
      <a href="" data-target="#specializari" data-toggle="tab" class="nav-link @if($active=='specializari') active @endif">Servicii</a>
   </li>
   <li class="nav-item">
      <a href="" data-target="#cabinete" data-toggle="tab" class="nav-link @if($active=='cabinet') active @endif">Cabinete</a>
   </li>
   <li class="nav-item">
      <a href="" data-target="#doctori" data-toggle="tab" class="nav-link  @if($active=='doctor') active @endif">Doctori</a>
   </li>
</ul>
@foreach ($errors->all() as $error)
<div>{{ $error }}</div>
@endforeach
<div class="tab-content py-4 text-center">
   <div class="tab-pane  @if($active=='specializari') active @endif" id="specializari">
      <div class="row">

         <div class="col">
            @if(Session::has('success'))
               <div class="alert alert-info">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <h4>{{Session::get('success')}}</h4>
               </div>
            @endif
            @if(Session::has('error'))
               <div class="alert alert-info">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <h4>{{Session::get('error')}}</h4>
               </div>
            @endif
            <div class="card">
               <div class="card-body">
                  <div class="text-center">
                     <form method="POST" action="{{route('cabinet.addspeci')}}">
                        @csrf
                        <div class="form-group">
                           <input type="text" class="form-control" placeholder="Specializare" name="specializare" required>

                        </div>
                        <input type="submit" class=" btn btn-success" placeholder="Last name" value="Adăugă">
                     </form>
                  </div>
                  <h5 class="card-title text-center">Specializările disponibile în stomatologie.</h5>
                  <div style="overflow-x:auto;">
                     <table id="table_id" class="table table-striped table-bordered specializare">
                        <thead>
                           <tr>
                              <th width="3%">#</th>
                              <th >Specializare</th>
                              <th >Dată</th>
                              <th  width="3%">Sterge</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if($spec!=null) 
                           @foreach($spec as $indexKey => $spc)
                           <tr>
                              <td>{{++$indexKey}}</td>
                              <td>{{$spc->specializare}}</td>
                              <td>{{$spc->created_at}}</td>
                              <td>
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{$indexKey}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 <div class="modal fade" id="{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title">{{$spc->specializare}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <p>Prin stergerea specializărilor se sterg automat și servicile. Pentru a confirma stergerea apasă OK.</p>
                                          </div>
                                          <div class="modal-footer">
                                             <form action="{{route('cabinet.delspeci')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$spc->id}}" name="id">
                                                <button type="submit" class="btn btn-success">OK</button>
                                             </form>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                        <tfoot>
                           <th width="3%">#</th>
                           <th >Specializare</th>
                           <th >Dată</th>
                           <th  width="3%">Sterge</th>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card">
               <div class="card-body">
                  <div class="text-center">
                  @if($spec!=null)
                     <form action="{{route('cabinet.addserv')}}" method="POST">
                        @csrf
                        <div class="form-group">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-xl-3">
                                 <select class="custom-select" name="specializare">
                                    @foreach($spec as $speci)
                                       <option value="{{$speci->specializare}}(*){{$speci->id}}">{{$speci->specializare}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-lg-3 col-md-3 col-xl-3 ">
                                 <input type="number" step="0.1" pattern="[0-9]+(\.[0-9]{0,2})?%?" min="10" class="form-control" name="pret" placeholder="Preț în RON" required>
                              </div>
                              <div class="col-lg-3 col-md-3 col-xl-3">
                                 <input type="number" step="5" pattern="\d" min="5" class="form-control" name="durata" placeholder="Durată medie (m)" required>
                              </div>
                              <div class="col-lg-3 col-md-3 col-xl-3">
                                 <input type="text" class="form-control" name="serviciu" placeholder="Serviciul oferit" required>
                              </div>
                           </div>
                        </div>
                              <input type="submit" class="btn btn-success text-center" value="Adaugă">
                     </form>
                  @else
                     <h4 class="text-center">Servicile se pot adăuga unei specializări, prima dată trebuie să adăugați specializările.</h4>
                  @endif
                  </div>
                     <h5 class="card-title text-center">Servicii disponibile în stomatologie.</h5>

                  <div style="overflow-x:auto;">
                     <table id="table_id1" class="table table-striped table-bordered ">
                        <thead>
                           <tr>
                              <th width="3%">#</th>
                              <th>Specializare</th>
                              <th>Serviciu</th>
                              <th>Pret</th>
                              <th>Durată</th>
                              <th width="3%">Sterge/Schimbă</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if($servicii!=null) 
                           @foreach($servicii as $indexKey => $serv)
                           <tr>
                              <td width="3%">{{++$indexKey}}</td>
                              <td> 
                                 <?php 
                                    $var = DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id', $serv->id_specializare)->select('specializare')->first(); 
                                    echo $var->specializare;?> 
                              </td>
                              <td>{{$serv->denumire}}</td>
                              <td>{{$serv->pret}}</td>
                              <td>{{$serv->durata}}</td>
                              <td width="3%">
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#serv{{$indexKey}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 <div class="modal fade" id="serv{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title">Serviciu: {{$serv->denumire}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <p>Pentru a confirma stergerea apasă OK.</p>
                                          </div>
                                          <div class="modal-footer">
                                             <form action="{{route('cabinet.delserv')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$serv->id}}" name="id">
                                                <button type="submit" class="btn btn-success">OK</button>
                                             </form>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                              </td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                        <tfoot>
                           <th width="3%">#</th>
                           <th>Specializare</th>
                           <th>Serviciu</th>
                           <th>Pret</th>
                           <th>Durată</th>
                           <th width="3%">Sterge/Schimbă</th>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="tab-pane  @if($active=='cabinet') active @endif" id="cabinete">
      <div class="row">
         <div class="col">
            <form method="POST" action="{{route('cabinet.addsala')}}">
               @csrf
               <div class="row">
                  <div class="col-lg-2 col-md-4 col-xl-3">
                     <input type="text" class="form-control" placeholder="Etaj" name="etaj" required>
                  </div>
                  <div class="col-lg-2 col-md-4 col-xl-3">
                     <input type="text" class="form-control" placeholder="Cabinet" name="cabinet" required>
                  </div>
                  <div class="col-lg-2 col-md-4 col-xl-3">
                     <input type="submit" class="form-control btn btn-success" value="Adăugare">
                  </div>
               </div>
            </form>
            <br/>
            @if(Session::has('success'))
            <div class="alert alert-info">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <h4>{{Session::get('success')}}</h4>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-info">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <h4>{{Session::get('error')}}</h4>
            </div>
            @endif
            <div class="card">
               <div class="card-body">
                  
                     <h5 class="card-title">Repartiția cabinetelor pe etaje.</h5>
                  
                  <div style="overflow-x:auto;">
                     <table id="cabinetet" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="3%">#</th>
                              <th>Etaj</th>
                              <th>Cabinet</th>
                              <th width="3%">Sterge</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if($sali!=null) 
                           @foreach($sali as $indexKeys => $spc)
                           <tr>
                              <td>{{++$indexKeys}}</td>
                              <td>{{$spc->etaj}}</td>
                              <td>{{$spc->numar}}</td>
                              <td>
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#sala{{$indexKeys}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 <div class="modal fade" id="sala{{$indexKeys}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title">Etaj: {{$spc->etaj}} / Cabinet: {{$spc->numar}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <p>Prin stergerea cabinetelor, doctorii ce aparțineau respectivului cabinet vor avea nevoie de un nou cabinet.</p>
                                          </div>
                                          <div class="modal-footer">
                                             <form action="{{route('cabinet.delsala')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$spc->id}}" name="id">
                                                <button type="submit" class="btn btn-success">OK</button>
                                             </form>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                        <tfoot>
                           <th width="3%">#</th>
                           <th >Etaj</th>
                           <th >Cabinet</th>
                           <th  width="3%">Sterge</th>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="tab-pane  @if($active=='doctor') active @endif" id="doctori">
      <h2 class="text-center">Adaugă un nou medic</h2>
      <hr>
      <div class="row">
         <div class="col-md-4 text-center">
            <img id="blah"  src="//placehold.it/200" class="mx-auto img-fluid rounded-circle d-block" alt="profil" height="200" width="200">
            <h6 class="mt-2">Imagine de profil</h6>
            <label for="file-upload" class="custom-file-upload">
            <a class="fa fa-cloud-upload"></a> Custom Upload
            </label>
            <input type="file" form="add" class="form-control" name="profile" id="file-upload" accept="image/*" onchange='document.getElementById("blah").src = window.URL.createObjectURL(this.files[0])'>        
            <br><br>
         </div>
         <div class="col-md-8 personal-info">
            @if(Session::has('success'))
            <div class="alert alert-info">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <h4>{{Session::get('success')}}</h4>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-info">
               <a href="#" class="close" data-dismiss="alert">&times;</a>
               <h4>{{Session::get('error')}}</h4>
            </div>
            @endif
            <form id="add" enctype="multipart/form-data" class="form-horizontal" role="form" method="POST" action="{{route('cabinet.addmedic')}}">
               @csrf
               <div class="form-group">
                  <div class="row">
                  <div class="col-lg-6"><label class="control-label">Nume:</label>
                     <input class="form-control" type="text" name="nume" placeholder="Nume" required>
                  </div>

                  <div class="col-lg-6"><label class="control-label">Prenume:</label>
                     <input class="form-control" type="text" name="prenume" placeholder="Prenume" required>
                  </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">


                  <div class="col-lg-6">
                     <label class="control-label">Descriere:</label>
                     <input class="form-control" type="text" maxlength="255" name="descriere" placeholder="Descriere" required>
                  </div>


                     <div class="col-lg-6"> <label class="control-label">Profesie:</label>
                        <input class="form-control" type="text" maxlength="100" name="profesie" placeholder="Profesie" required>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">

                  <div class="col-lg-4">
                     <label class=" control-label">Program</label>
                     <button type="button" class="btn btn-success form-control" data-toggle="modal" data-target="#newmedic">Setează Programul</button>
                     <div class="modal fade" id="newmedic" role="dialog">
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title">Setează un program pentru noul medic.</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="lunird()" id="luniS">
                                             Luni
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="Lstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startL" data-toggle="datetimepicker" data-target="#Lstart" readonly/>
                                                <div class="input-group-append" data-target="#Lstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="Lstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopL"  placeholder="Stop" data-target="#Lstop" readonly/>
                                                <div class="input-group-append" data-target="#Lstop" data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="martird()" id="martiS">
                                             Marți
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="MAstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startMA" data-toggle="datetimepicker" data-target="#MAstart" readonly/>
                                                <div class="input-group-append" data-target="#MAstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="MAstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopMA" placeholder="Stop" data-target="#MAstop" readonly/>
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
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="miercurird()" id="miercuriS">
                                             Miercuri
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="MIstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startMI" data-toggle="datetimepicker" data-target="#MIstart" readonly/>
                                                <div class="input-group-append" data-target="#MIstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="MIstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopMI" placeholder="Stop" data-target="#MIstop" readonly/>
                                                <div class="input-group-append" data-target="#MIstop" data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="joird()" id="joiS">
                                             Joi
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="Jstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startJ" data-toggle="datetimepicker" data-target="#Jstart" readonly/>
                                                <div class="input-group-append" data-target="#Jstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="Jstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopJ" placeholder="Stop" data-target="#Jstop" readonly/>
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
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="vinerird()" id="vineriS">
                                             Vineri
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="Vstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startV" data-toggle="datetimepicker" data-target="#Vstart" readonly/>
                                                <div class="input-group-append" data-target="#Vstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="Vstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopV" placeholder="Stop" data-target="#Vstop" readonly/>
                                                <div class="input-group-append" data-target="#Vstop" data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-check">
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="sambatard()" id="sambataS">
                                             Sâmbătă
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="Sstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startS" data-toggle="datetimepicker" data-target="#Sstart" readonly/>
                                                <div class="input-group-append" data-target="#Sstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="Sstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopS" placeholder="Stop" data-target="#Sstop" readonly/>
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
                                          <label class="form-check-label">
                                             <input form="add" class="form-check-input" type="checkbox" onclick="duminicard()" id="duminicaS">
                                             Duminică
                                             </label>
                                          
                                          <div class="form-group">
                                             <div class="input-group date" id="Dstart" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startD" data-toggle="datetimepicker" data-target="#Dstart" readonly/>
                                                <div class="input-group-append" data-target="#Dstart"  data-toggle="datetimepicker">
                                                   <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <div class="input-group date" id="Dstop" data-target-input="nearest">
                                                <input form="add" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopD" placeholder="Stop" data-target="#Dstop" readonly/>
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

                     <div class="col-lg-4"><label class=" control-label">Disponibilitate</label>
                        <select class="custom-select" name="disponibilitate" required>
                           <option value="1">Zilnic</option>
                           <option value="2">Săptămânal</option>
                           <option value="3">Lunar</option>
                        </select>
                     </div>

                     @if($sali!=null)


                           <div class="col-lg-4"><label class=" control-label">Cabinet</label>
                              <select class="custom-select" name="sala" required>
                                 @foreach($sali as $sala)
                                    <option value="{{$sala->id}}">Etaj: {{$sala->etaj}} / Sala: {{$sala->numar}}</option>
                                 @endforeach
                              </select>
                           </div>
                     @endif

                  </div>
               </div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-lg-4">
                        <label class="control-label">Gen</label>
                        <select class="form-control" name="gen">
                           <option value="f">Femeie</option>
                           <option value="m">Bărbat</option>
                        </select>
                     </div>
                     @if($spec!=null)


                        <div class="col-lg-4"><label class="control-label">Specializări</label>
                           <select class="custom-select form-control" name="specializare[]" required multiple>
                              @foreach($spec as $speci)
                                 <option value="{{$speci->id}}">{{$speci->specializare}}</option>
                              @endforeach
                           </select>
                        </div>

                     @endif
                     <div class="col-lg-4">
                        <label class="control-label"></label>
                        <input type="submit" class="btn btn-primary form-control" value="Adaugă">
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <hr>
      </hr>
      <div class="row">
         <div class="col">
            <div class="card">
               <div class="card-body">
                     <h5 class="card-title text-center">Personalul disponibil in <i>{{Auth::user()->name}}</i>.</h5>
                  <div style="overflow-x:auto;">
                     <table id="medic" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="3%">#</th>
                              <th width="3%">Poza</th>
                              <th>Nume</th>
                              <th>Prenume</th>
                              <th>Profesie</th>
                              <th>Gen</th>
                              <th>Specializări</th>
                              <th>Disponibilitate</th>
                              <th>Cabinet</th>
                              <th>Program</th>
                              <th width="3%">Unelte</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if($medici!=null) 
                           @foreach($medici as $indexKey => $medic)
                           <tr>
                              <td>{{++$indexKey}}</td>
                              <td>
                              @if($medic->img_profile!=null) 

                                <img src="{{$medic->img_profile}}" style="width:50px; height:50px; border-radius:50%">

                              @else 
                                <img src="//via.placeholder.com/50x50" style="width:50px; height:50px; border-radius:50%">
                              @endif
                              </td>
                              <td>{{$medic->nume}}</td>
                              <td>{{$medic->prenume}}</td>
                              <td>{{$medic->profesie}}</td>
                              <td>@if($medic->gen=="f")<i class="fa fa-female" aria-hidden="true"></i> @else <i class="fa fa-male" aria-hidden="true"></i> @endif</td>
                              <td class="scrolspeci">
                                 @if($medic->id_specializari!=null)
                                 @if(count(json_decode($medic->id_specializari,true))>0)
                                 <div data-toggle="modal" data-target="#specializare{{$indexKey}}" class="vertical-menu">
                                    @foreach(json_decode($medic->id_specializari) as $speci)
                                    <a>
                                    <?php 
                                       //use App\doctori;
                                       $var =  DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id',$speci)->select('specializare')->where('id_cab',Auth::user()->id)->first();
                                       echo $var->specializare;
                                       ?>
                                    </a>
                                    @endforeach 
                                 </div>
                                 <div class="modal fade" id="specializare{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <h1>Sterge o specializare</h1>
                                             <form method="POST" id="delete{{$indexKey}}" action="{{route('cabinet.medic.delspeci')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$medic->id}}">
                                                <label class="control-label">Specializări</label>
                                                <select class="custom-select" name="specializare[]" required multiple>
                                                   @foreach(json_decode($medic->id_specializari) as $speci)
                                                   <option value="{{$speci}}">
                                                      <?php 
                                                         //use App\doctori;
                                                         $var =  DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id',$speci)->select('specializare')->where('id_cab',Auth::user()->id)->first();
                                                         echo $var->specializare;
                                                         ?>
                                                   </option>
                                                   @endforeach
                                                </select>
                                             </form>
                                             <h1>Adaugă o specializare</h1>
                                             <form method="POST" id="add{{$indexKey}}" action="{{route('cabinet.medic.addspeci')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$medic->id}}">
                                                <div class="form-group">
                                                   <label class=" control-label">Specializări</label>
                                                   <div class="">
                                                      <select class="custom-select" name="specializare[]" required multiple>
                                                         @foreach($spec as $specia)
                                                         <?php
                                                            $c=0;
                                                            ?>
                                                         @foreach(json_decode($medic->id_specializari) as $speci)
                                                         @if($specia->id==$speci)
                                                         <?php $c=$c+1;?>
                                                         @endif
                                                         @endforeach
                                                         @if($c==0)
                                                         <option value="{{$specia->id}}">
                                                            <?php 
                                                               //use App\doctori;
                                                               $var =  DB::connection('stomatime_'.Auth::user()->id)->table('specializari')->where('id',$specia->id)->select('specializare')->where('id_cab',Auth::user()->id)->first();
                                                               echo $var->specializare;
                                                               ?>
                                                         </option>
                                                         @endif
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" form="delete{{$indexKey}}" class="btn btn-danger">Sterge</button>
                                             <button type="submit" form="add{{$indexKey}}" class="btn btn-success">Adaugă</button>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <span class="badge badge-warning"> <a  data-toggle="modal" data-target="#setspeci{{$indexKey}}">Nesetat</a></span>
                                 <div class="modal fade" id="setspeci{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4>Setează specializările medicului: {{$medic->nume}} {{$medic->prenume}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             @if($spec!=null)
                                             <form method="POST" id="setspecimedic{{$indexKey}}" action="{{route('cabinet.medic.set.speci')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$medic->id}}">
                                                <label class="control-label">Cabinet</label>
                                                <select class="custom-select" name="specializare[]" required multiple>
                                                   @foreach($spec as $speci)
                                                   <option value="{{$speci->id}}">{{$speci->specializare}}</option>
                                                   @endforeach
                                                </select>
                                             </form>
                                             @else
                                             Pentru a face corespondența dintre medic și specializare trebuie să existe minim o specializare adăugată.
                                             @endif
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" form="setspecimedic{{$indexKey}}" class="btn btn-success">Setează</button>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @else
                                 <span class="badge badge-warning"> <a  data-toggle="modal" data-target="#setspeci{{$indexKey}}">Nesetat</a></span>
                                 <div class="modal fade" id="setspeci{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4>Setează specializările medicului: {{$medic->nume}} {{$medic->prenume}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             @if($spec!=null)
                                             <form method="POST" id="setspecimedic" action="{{route('cabinet.medic.set.speci')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$medic->id}}">
                                                <label class="control-label">Cabinet</label>
                                                <select class="custom-select" name="specializare[]" required multiple>
                                                   @foreach($spec as $speci)
                                                   <option value="{{$speci->id}}">{{$speci->specializare}}</option>
                                                   @endforeach
                                                </select>
                                             </form>
                                             @else
                                             Pentru a face corespondența dintre medic și specializare trebuie să existe minim o specializare adăugată.
                                             @endif
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" form="setspecimedic" class="btn btn-success">Setează</button>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                              </td>
                              <td>
                                 @switch($medic->frecventa)
                                 @case(1)
                                 Zilnic
                                 @break
                                 @case(2)
                                 Saptămănal
                                 @break
                                 @default
                                 Lunar
                                 @endswitch
                              </td>
                              <td>
                                 @if($medic->id_sala!=null)
                                 <a  data-toggle="modal" data-target="#editcab{{$indexKey}}">
                                 <?php
                                    $sala =  DB::connection('stomatime_'.Auth::user()->id)->table('sali')->where('id',$medic->id_sala)->where('id_cab',Auth::user()->id)->first();
                                    echo "Etaj:".$sala->etaj."/Cabinet:".$sala->numar;
                                    ?>
                                 </a>
                                 <div class="modal fade" id="editcab{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4>Editează-i cabinetul medicului: {{$medic->nume}} {{$medic->prenume}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <form method="POST" id="setsalamedic{{$indexKey}}" action="{{route('cabinet.medic.set.sala')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$medic->id}}">
                                                <label class="control-label">Cabinet</label>
                                                <select class="custom-select" name="sala" required>
                                                   @foreach($sali as $sala)
                                                   <option value="{{$sala->id}}">Etaj: {{$sala->etaj}} / Sala: {{$sala->numar}}</option>
                                                   @endforeach
                                                   <option value="sterge">Sterge</option>
                                                </select>
                                             </form>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" form="setsalamedic{{$indexKey}}" class="btn btn-success">Setează</button>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <span class="badge badge-warning"> <a  data-toggle="modal" data-target="#setcab{{$indexKey}}">Nesetat</a></span>
                                 <div class="modal fade" id="setcab{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4>Setează un cabinet pentru medicul: {{$medic->nume}} {{$medic->prenume}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             @if($sali==null)
                                             Pentru a face corespondența dintre medic și cabinet trebuie să existe minim un cabinet adăugat.
                                             @else
                                             <form method="POST" id="setsalamedicc{{$indexKey}}" action="{{route('cabinet.medic.set.sala')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$medic->id}}">
                                                <label class="control-label">Cabinet</label>
                                                <select class="custom-select" name="sala" required>
                                                   @foreach($sali as $sala)
                                                   <option value="{{$sala->id}}">Etaj: {{$sala->etaj}} / Sala: {{$sala->numar}}</option>
                                                   @endforeach
                                                </select>
                                             </form>
                                             @endif
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" form="setsalamedicc{{$indexKey}}" class="btn btn-success">Setează</button>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                              </td>
                              <td>
                                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#program{{$medic->id}}">Program</button>
                                 <div class="modal fade" id="program{{$medic->id}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title">Vizualizare/Editare pentru medicul {{$medic->prenume}} {{$medic->nume}}</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                          <form method="POST" id="editprogram{{$medic->id}}" action="{{route('cabinet.medic.edit.program')}}">
                                          @csrf
                                            <input type="hidden" value="{{$medic->id}}" name="id">
                                             <div class="row text-center">
                                                <div class="col-md-6">
                                                   <div class="form-check">
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="lunird{{$medic->id}}()" id="luniS{{$medic->id}}">
                                                         Luni
                                                         </label>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Lstart{!!$medic->id!!}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startL{!!$medic->id!!}" data-toggle="datetimepicker" data-target="#Lstart{!!$medic->id!!}" readonly/>
                                                            <div class="input-group-append" id="{!!$medic->id!!}" data-target="#Lstart{!!$medic->id!!}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Lstop{!!$medic->id!!}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopL{!!$medic->id!!}"  placeholder="Stop" data-target="#Lstop{!!$medic->id!!}" readonly/>
                                                            <div class="input-group-append" id="{!!$medic->id!!}" data-target="#Lstop{!!$medic->id!!}" data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-check">
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="martird{!!$medic->id!!}()" id="martiS{{$medic->id}}">
                                                         Marți
                                                         </label>
                                                      
                                                      <div class="form-group">
                                                         <div class="input-group date" id="MAstart{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startMA{{$medic->id}}" data-toggle="datetimepicker" data-target="#MAstart{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#MAstart{{$medic->id}}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="MAstop{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopMA{{$medic->id}}" placeholder="Stop" data-target="#MAstop{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#MAstop{{$medic->id}}" data-toggle="datetimepicker">
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
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="miercurird{!!$medic->id!!}()" id="miercuriS{{$medic->id}}">
                                                         Miercuri
                                                         </label>
                                                      
                                                      <div class="form-group">
                                                         <div class="input-group date" id="MIstart{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startMI{{$medic->id}}" data-toggle="datetimepicker" data-target="#MIstart{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#MIstart{{$medic->id}}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="MIstop{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopMI{{$medic->id}}" placeholder="Stop" data-target="#MIstop{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#MIstop{{$medic->id}}" data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-check">
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="joird{!!$medic->id!!}()" id="joiS{{$medic->id}}">
                                                         Joi
                                                         </label>
                                                      
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Jstart{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startJ{{$medic->id}}" data-toggle="datetimepicker" data-target="#Jstart{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Jstart{{$medic->id}}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Jstop{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopJ{{$medic->id}}" placeholder="Stop" data-target="#Jstop{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Jstop{{$medic->id}}" data-toggle="datetimepicker">
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
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="vinerird{!!$medic->id!!}()" id="vineriS{{$medic->id}}">
                                                         Vineri
                                                         </label>
                                                      
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Vstart{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startV{{$medic->id}}" data-toggle="datetimepicker" data-target="#Vstart{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Vstart{{$medic->id}}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Vstop{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopV{{$medic->id}}" placeholder="Stop" data-target="#Vstop{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Vstop{{$medic->id}}" data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-check">
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="sambatard{!!$medic->id!!}()" id="sambataS{{$medic->id}}">
                                                         Sâmbătă
                                                         </label>
                                                      
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Sstart{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startS{{$medic->id}}" data-toggle="datetimepicker" data-target="#Sstart{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Sstart{{$medic->id}}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Sstop{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopS{{$medic->id}}" placeholder="Stop" data-target="#Sstop{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Sstop{{$medic->id}}" data-toggle="datetimepicker">
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
                                                      <label class="form-check-label">
                                                         <input form="editprogram{{$medic->id}}" class="form-check-input" type="checkbox" onclick="duminicard{!!$medic->id!!}()" id="duminicaS{{$medic->id}}">
                                                         Duminică
                                                         </label>
                                                      
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Dstart{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" placeholder="Start" id="startD{{$medic->id}}" data-toggle="datetimepicker" data-target="#Dstart{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Dstart{{$medic->id}}"  data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <div class="input-group date" id="Dstop{{$medic->id}}" data-target-input="nearest">
                                                            <input form="editprogram{{$medic->id}}" type="text" class="form-control datetimepicker-input" data-toggle="datetimepicker" id="stopD{{$medic->id}}" placeholder="Stop" data-target="#Dstop{{$medic->id}}" readonly/>
                                                            <div class="input-group-append" data-target="#Dstop{{$medic->id}}" data-toggle="datetimepicker">
                                                               <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             </form>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="submit" form="editprogram{{$medic->id}}" class="btn btn-success">Editează</button>
                                             <button type="button" class="btn btn-damage" data-dismiss="modal">Închide</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @if($medic->orar!==null)
                                 <script>
                                    $(document).ready(function() {
                                        var array = {!! $medic->orar !!};

                                        if(array!=null)
                                        {
                                            if(array['luni']!=null)
                                            {
                                            document.getElementById("luniS{{$medic->id}}").checked=true;
                                            document.getElementById("startL{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopL{{$medic->id}}").readOnly = false;
                                    
                                            document.getElementById("stopL{{$medic->id}}").required = true;
                                            document.getElementById("startL{{$medic->id}}").required = true;

                                            document.getElementById("startL{{$medic->id}}").value = array['luni']['start'];
                                            document.getElementById("stopL{{$medic->id}}").value = array['luni']['stop'];
                                    
                                    
                                            document.getElementById("startL{{$medic->id}}").setAttribute("name", "program[luni][start]");
                                            document.getElementById("stopL{{$medic->id}}").setAttribute("name", "program[luni][stop]");
                                            }
                                            if(array['marti']!=null)
                                            {
                                                document.getElementById("martiS{{$medic->id}}").checked=true;
                                            document.getElementById("startMA{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopMA{{$medic->id}}").readOnly = false;
                                    
                                            document.getElementById("stopMA{{$medic->id}}").required = true;
                                            document.getElementById("startMA{{$medic->id}}").required = true;
                                    
                                            document.getElementById("stopMA{{$medic->id}}").value = array['marti']['stop'];
                                            document.getElementById("startMA{{$medic->id}}").value = array['marti']['start'];

                                            document.getElementById("startMA{{$medic->id}}").setAttribute("name", "program[marti][start]");
                                            document.getElementById("stopMA{{$medic->id}}").setAttribute("name", "program[marti][stop]");
                                            }
                                            if(array['miercuri']!=null)
                                            {
                                                document.getElementById("miercuriS{{$medic->id}}").checked=true;
                                                document.getElementById("startMI{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopMI{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopMI{{$medic->id}}").required = true;
                                            document.getElementById("startMI{{$medic->id}}").required = true;

                                                document.getElementById("stopMI{{$medic->id}}").value = array['miercuri']['stop'];
                                                document.getElementById("startMI{{$medic->id}}").value = array['miercuri']['start'];

                                            document.getElementById("startMI{{$medic->id}}").setAttribute("name", "program[miercuri][start]");
                                            document.getElementById("stopMI{{$medic->id}}").setAttribute("name", "program[miercuri][stop]");

                                            }
                                            if(array['joi']!=null)
                                            {
                                                document.getElementById("joiS{{$medic->id}}").checked=true;
                                                document.getElementById("startJ{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopJ{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopJ{{$medic->id}}").required = true;
                                            document.getElementById("startJ{{$medic->id}}").required = true;
                                            document.getElementById("startJ{{$medic->id}}").setAttribute("name", "program[joi][start]");
                                            document.getElementById("stopJ{{$medic->id}}").setAttribute("name", "program[joi][stop]");
                                            document.getElementById("stopJ{{$medic->id}}").value = array['joi']['stop'];
                                                document.getElementById("startJ{{$medic->id}}").value = array['joi']['start'];
                                            }
                                            if(array['vineri']!=null)
                                            {
                                                document.getElementById("vineriS{{$medic->id}}").checked=true;
                                                document.getElementById("startV{{$medic->id}}").readOnly = false;
                                                document.getElementById("stopV{{$medic->id}}").readOnly = false;
                                                document.getElementById("stopV{{$medic->id}}").required = true;
                                                document.getElementById("startV{{$medic->id}}").required = true;
                                                document.getElementById("startV{{$medic->id}}").setAttribute("name", "program[vineri][start]");
                                                document.getElementById("stopV{{$medic->id}}").setAttribute("name", "program[vineri][stop]");
                                                document.getElementById("stopV{{$medic->id}}").value = array['vineri']['stop'];
                                                    document.getElementById("startV{{$medic->id}}").value = array['vineri']['start'];
                                            }
                                            if(array['sambata']!=null)
                                            {
                                                document.getElementById("sambataS{{$medic->id}}").checked=true;
                                                document.getElementById("startS{{$medic->id}}").readOnly = false;
                                                document.getElementById("stopS{{$medic->id}}").readOnly = false;
                                                document.getElementById("stopS{{$medic->id}}").required = true;
                                                document.getElementById("startS{{$medic->id}}").required = true;
                                                document.getElementById("startS{{$medic->id}}").setAttribute("name", "program[sambata][start]");
                                                document.getElementById("stopS{{$medic->id}}").setAttribute("name", "program[sambata][stop]");
                                                document.getElementById("stopS{{$medic->id}}").value = array['sambata']['stop'];
                                                    document.getElementById("startS{{$medic->id}}").value = array['sambata']['start'];
                                            }
                                            if(array['duminica']!=null)
                                            {
                                                document.getElementById("duminicaS{{$medic->id}}").checked=true;
                                                document.getElementById("startD{{$medic->id}}").readOnly = false;
                                                document.getElementById("stopD{{$medic->id}}").readOnly = false;
                                                document.getElementById("stopD{{$medic->id}}").required = true;
                                                document.getElementById("startD{{$medic->id}}").required = true;
                                                document.getElementById("startD{{$medic->id}}").setAttribute("name", "program[duminica][start]");
                                                document.getElementById("stopD{{$medic->id}}").setAttribute("name", "program[duminica][stop]");
                                                document.getElementById("stopD{{$medic->id}}").value = array['duminica']['stop'];
                                                document.getElementById("startD{{$medic->id}}").value = array['duminica']['start'];
                                            }
                                        }
                                    });
                                </script>
                                 @endif
                                <script>
                                    $(function() {
                                        $('#Lstart{!!$medic->id!!}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#Lstop{!!$medic->id!!}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#Lstart{!!$medic->id!!}").on("change.datetimepicker", function(e) {
                                            $('#Lstop{!!$medic->id!!}').datetimepicker('minDate', e.date);
                                        });
                                        $("#Lstop{!!$medic->id!!}").on("change.datetimepicker", function(e) {
                                            $('#Lstart{!!$medic->id!!}').datetimepicker('maxDate', e.date);
                                        });
                                    
                                        $('#MAstart{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#MAstop{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#MAstart{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#MAstop{{$medic->id}}').datetimepicker('minDate', e.date);
                                        });
                                        $("#MAstop{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#MAstart{{$medic->id}}').datetimepicker('maxDate', e.date);
                                        });
                                    
                                        $('#MIstart{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#MIstop{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#MIstart{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#MIstop{{$medic->id}}').datetimepicker('minDate', e.date);
                                        });
                                        $("#MIstop{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#MIstart{{$medic->id}}').datetimepicker('maxDate', e.date);
                                        });
                                    
                                        $('#Jstart{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#Jstop{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#Jstart{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Jstop{{$medic->id}}').datetimepicker('minDate', e.date);
                                        });
                                        $("#Jstop{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Jstart{{$medic->id}}').datetimepicker('maxDate', e.date);
                                        });
                                    
                                        $('#Vstart{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#Vstop{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#Vstart{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Vstop{{$medic->id}}').datetimepicker('minDate', e.date);
                                        });
                                        $("#Vstop{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Vstart{{$medic->id}}').datetimepicker('maxDate', e.date);
                                        });
                                    
                                        $('#Sstart{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#Sstop{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#Sstart{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Sstop{{$medic->id}}').datetimepicker('minDate', e.date);
                                        });
                                        $("#Sstop{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Sstart{{$medic->id}}').datetimepicker('maxDate', e.date);
                                        });
                                    
                                        $('#Dstart{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#Dstop{{$medic->id}}').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $("#Dstart{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Dstop{{$medic->id}}').datetimepicker('minDate', e.date);
                                        });
                                        $("#Dstop{{$medic->id}}").on("change.datetimepicker", function(e) {
                                            $('#Dstart{{$medic->id}}').datetimepicker('maxDate', e.date);
                                        });
                                    });
                                    
                                    function lunird{!!$medic->id!!}() {
                                        var cb = document.getElementById("luniS{{$medic->id}}");
                                        if (cb.checked == true) {
                                            document.getElementById("startL{{$medic->id}}").readOnly = false;
                                            document.getElementById("stopL{{$medic->id}}").readOnly = false;
                                    
                                            document.getElementById("stopL{{$medic->id}}").required = true;
                                            document.getElementById("startL{{$medic->id}}").required = true;
                                    
                                            document.getElementById("startL{{$medic->id}}").setAttribute("name", "program[luni][start]");
                                            document.getElementById("stopL{{$medic->id}}").setAttribute("name", "program[luni][stop]");
                                        } else {
                                            document.getElementById("startL{{$medic->id}}").readOnly = true;
                                            document.getElementById("stopL{{$medic->id}}").readOnly = true;
                                    
                                            document.getElementById("stopL{{$medic->id}}").required = false;
                                            document.getElementById("startL{{$medic->id}}").required = false;
                                    
                                            document.getElementById("startL{{$medic->id}}").removeAttribute("name");
                                            document.getElementById("stopL{{$medic->id}}").removeAttribute("name");
                                        }
                                    }
                                    
                                    function martird{!!$medic->id!!}() {
                                        var cb = document.getElementById("martiS{!!$medic->id!!}");
                                        if (cb.checked == true) {
                                            document.getElementById("startMA{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopMA{!!$medic->id!!}").readOnly = false;
                                    
                                            document.getElementById("stopMA{!!$medic->id!!}").required = true;
                                            document.getElementById("startMA{!!$medic->id!!}").required = true;
                                    
                                            document.getElementById("startMA{!!$medic->id!!}").setAttribute("name", "program[marti][start]");
                                            document.getElementById("stopMA{!!$medic->id!!}").setAttribute("name", "program[marti][stop]");
                                        } else {
                                            document.getElementById("startMA{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopMA{!!$medic->id!!}").readOnly = true;
                                    
                                            document.getElementById("startMA{!!$medic->id!!}").required = false;
                                            document.getElementById("stopMA{!!$medic->id!!}").required = false;
                                    
                                            document.getElementById("startMA{!!$medic->id!!}").removeAttribute("name");
                                            document.getElementById("stopMA{!!$medic->id!!}").removeAttribute("name");
                                        }
                                    }
                                    
                                    function miercurird{!!$medic->id!!}() {
                                        var cb = document.getElementById("miercuriS{!!$medic->id!!}");
                                        if (cb.checked == true) {
                                            document.getElementById("startMI{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopMI{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopMI{!!$medic->id!!}").required = true;
                                            document.getElementById("startMI{!!$medic->id!!}").required = true;
                                            document.getElementById("startMI{!!$medic->id!!}").setAttribute("name", "program[miercuri][start]");
                                            document.getElementById("stopMI{!!$medic->id!!}").setAttribute("name", "program[miercuri][stop]");
                                        } else {
                                            document.getElementById("startMI{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopMI{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopMI{!!$medic->id!!}").required = false;
                                            document.getElementById("startMI{!!$medic->id!!}").required = false;
                                            document.getElementById("startMI{!!$medic->id!!}").removeAttribute("name");
                                            document.getElementById("stopMI{!!$medic->id!!}").removeAttribute("name");
                                        }
                                    }
                                    
                                    function joird{!!$medic->id!!}() {
                                        var cb = document.getElementById("joiS{!!$medic->id!!}");
                                        if (cb.checked == true) {
                                            document.getElementById("startJ{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopJ{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopJ{!!$medic->id!!}").required = true;
                                            document.getElementById("startJ{!!$medic->id!!}").required = true;
                                            document.getElementById("startJ{!!$medic->id!!}").setAttribute("name", "program[joi][start]");
                                            document.getElementById("stopJ{!!$medic->id!!}").setAttribute("name", "program[joi][stop]");
                                        } else {
                                            document.getElementById("startJ{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopJ{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopJ{!!$medic->id!!}").required = false;
                                            document.getElementById("startJ{!!$medic->id!!}").required = false;
                                            document.getElementById("startJ{!!$medic->id!!}").removeAttribute("name");
                                            document.getElementById("stopJ{!!$medic->id!!}").removeAttribute("name");
                                        }
                                    }
                                    
                                    function vinerird{!!$medic->id!!}() {
                                        var cb = document.getElementById("vineriS{!!$medic->id!!}");
                                        if (cb.checked == true) {
                                            document.getElementById("startV{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopV{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopV{!!$medic->id!!}").required = true;
                                            document.getElementById("startV{!!$medic->id!!}").required = true;
                                            document.getElementById("startV{!!$medic->id!!}").setAttribute("name", "program[vineri][start]");
                                            document.getElementById("stopV{!!$medic->id!!}").setAttribute("name", "program[vineri][stop]");
                                        } else {
                                            document.getElementById("startV{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopV{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopV{!!$medic->id!!}").required = false;
                                            document.getElementById("startV{!!$medic->id!!}").required = false;
                                            document.getElementById("startV{!!$medic->id!!}").removeAttribute("name");
                                            document.getElementById("stopV{!!$medic->id!!}").removeAttribute("name");
                                        }
                                    }
                                    
                                    function sambatard{!!$medic->id!!}() {
                                        var cb = document.getElementById("sambataS{!!$medic->id!!}");
                                        if (cb.checked == true) {
                                            document.getElementById("startS{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopS{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopS{!!$medic->id!!}").required = true;
                                            document.getElementById("startS{!!$medic->id!!}").required = true;
                                            document.getElementById("startS{!!$medic->id!!}").setAttribute("name", "program[sambata][start]");
                                            document.getElementById("stopS{!!$medic->id!!}").setAttribute("name", "program[sambata][stop]");
                                        } else {
                                            document.getElementById("startS{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopS{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopS{!!$medic->id!!}").required = false;
                                            document.getElementById("startS{!!$medic->id!!}").required = false;
                                            document.getElementById("startS{!!$medic->id!!}").removeAttribute("name");
                                            document.getElementById("stopS{!!$medic->id!!}").removeAttribute("name");
                                        }
                                    }
                                    
                                    function duminicard{!!$medic->id!!}() {
                                        var cb = document.getElementById("duminicaS{!!$medic->id!!}");
                                        if (cb.checked == true) {
                                            document.getElementById("startD{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopD{!!$medic->id!!}").readOnly = false;
                                            document.getElementById("stopD{!!$medic->id!!}").required = true;
                                            document.getElementById("startD{!!$medic->id!!}").required = true;
                                            document.getElementById("startD{!!$medic->id!!}").setAttribute("name", "program[duminica][start]");
                                            document.getElementById("stopD{!!$medic->id!!}").setAttribute("name", "program[duminica][stop]");
                                        } else {
                                            document.getElementById("startD{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopD{!!$medic->id!!}").readOnly = true;
                                            document.getElementById("stopD{!!$medic->id!!}").required = false;
                                            document.getElementById("startD{!!$medic->id!!}").required = false;
                                            document.getElementById("startD{!!$medic->id!!}").removeAttribute("name");
                                            document.getElementById("stopD{!!$medic->id!!}").removeAttribute("name");
                                        }
                                    }
                                </script>
                              </td>
                              <td>
                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#medic{{$indexKey}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 <div class="modal fade" id="medic{{$indexKey}}" role="dialog">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                             <h1>Nu am facut stergerea inca, deoarece lucrez la un sistem de pastrare in Arhiva a medicilor stersi.</h1>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           @endforeach
                           @endif
                        </tbody>
                        <tfoot>
                           <th width="3%">#</th>
                           <th width="3%">Poza</th>
                           <th>Nume</th>
                           <th>Prenume</th>
                           <th>Profesie</th>
                           <th>Gen</th>
                           <th>Specializări</th>
                           <th>Disponibilitate</th>
                           <th>Cabinet</th>
                           <th>Program</th>
                           <th width="3%">Unelte</th>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
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
<script>
   window.setTimeout(function() {
       $(".alert-info").fadeTo(500, 0).slideUp(500, function() {
           $(this).remove();
       });
   }, 2000);
</script>
<script>
   $(document).ready(function() {
          $('#medic tfoot th').each(function() {
   
              var title = $(this).text();
              if (title == "Unelte" || title == "#" || title=="Program" || title=="Poza" || title=="Gen") {} else {
                  $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
              }
          });
          var table = $('#medic').DataTable({
              dom: 'Bfrtip',
              buttons: [{
                      extend: 'excelHtml5',
   
                      className: 'btn btn-info',
                      exportOptions: {
                          columns: [0,2,4,3,7]
                      }
                  },
                  {
                      extend: 'csvHtml5',
                      className: 'btn btn-info',
                      exportOptions: {
                          columns: [0,2,4,3,7]
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      messageTop: 'Medici',
                      className: 'btn btn-info',
                      exportOptions: {
                          columns: [0,2,4,3,7]
                      }
                  },
                  {
                      extend: 'print',
                      className: 'btn btn-info',
                      exportOptions: {
                          columns: [0,2,4,3,7]
                      }
                  }
              ],
              "paging": true,
              "ordering": true,
              "info": true,
          });
          table.columns().every(function() {
              var that = this;
              $('input', this.footer()).on('keyup change', function() {
                  if (that.search() !== this.value) {
                      that
                          .search(this.value)
                          .draw();
                  }
              });
          });
      });
</script>
<script>
   $(document).ready(function() {
       $('#table_id tfoot th').each(function() {
   
           var title = $(this).text();
           if (title == "Sterge" || title == "#") {} else {
               $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
           }
       });
       var table = $('#table_id').DataTable({
           dom: 'Bfrtip',
           buttons: [{
                   extend: 'excelHtml5',
   
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               },
               {
                   extend: 'csvHtml5',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               },
               {
                   extend: 'pdfHtml5',
                   messageTop: 'Toate specializarile',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               },
               {
                   extend: 'print',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               }
           ],
           "paging": true,
           "ordering": true,
           "info": true,
       });
       table.columns().every(function() {
           var that = this;
           $('input', this.footer()).on('keyup change', function() {
               if (that.search() !== this.value) {
                   that
                       .search(this.value)
                       .draw();
               }
           });
       });
   });
</script>
<script>
   $(document).ready(function() {
       $('#table_id1 tfoot th').each(function() {
   
           var title = $(this).text();
           if (title == "Sterge/Schimbă" || title == "#") {} else {
               $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
           }
       });
       var table = $('#table_id1').DataTable({
           dom: 'Bfrtip',
           buttons: [{
                   extend: 'excelHtml5',
   
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2, 3,4]
                   }
               },
               {
                   extend: 'csvHtml5',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2, 3,4]
                   }
               },
               {
                   extend: 'pdfHtml5',
                   messageTop: 'Toate serviciile disponibile.',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2, 3,4]
                   }
               },
               {
                   extend: 'print',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2, 3,4]
                   }
               }
           ],
           "paging": true,
           "ordering": true,
           "info": true,
       });
       table.columns().every(function() {
           var that = this;
           $('input', this.footer()).on('keyup change', function() {
               if (that.search() !== this.value) {
                   that
                       .search(this.value)
                       .draw();
               }
           });
       });
   });
</script>
<script>
   $(document).ready(function() {
       $('#cabinetet tfoot th').each(function() {
   
           var titls = $(this).text();
           if (titls == "Sterge" || titls == "#") {} else {
               $(this).html('<input type="text" class="form-control" placeholder="' + titls + '" />');
           }
       });
       var table = $('#cabinetet').DataTable({
           dom: 'Bfrtip',
           buttons: [{
                   extend: 'excelHtml5',
   
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               },
               {
                   extend: 'csvHtml5',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               },
               {
                   extend: 'pdfHtml5',
                   messageTop: 'Toate cabinetele disponibile.',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               },
               {
                   extend: 'print',
                   className: 'btn btn-info',
                   exportOptions: {
                       columns: [0, 1, 2]
                   }
               }
           ],
           "paging": true,
           "ordering": true,
           "info": true,
       });
       table.columns().every(function() {
           var that = this;
           $('input', this.footer()).on('keyup change', function() {
               if (that.search() !== this.value) {
                   that
                       .search(this.value)
                       .draw();
               }
           });
       });
   });
</script>
@endsection