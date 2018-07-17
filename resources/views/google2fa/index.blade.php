@extends('layouts.app')

@section('content')
<div class="container">
<center>
    <div class="row">
        <div class="col">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('2fa') }}">
                        @csrf
                        <div class="form-group">
                        <label class="col-md-4 control-label">Two Factor Authentication</label>
                            <br>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="one_time_password" required>
                            </div>
                            <div class="col-md-6 col-md-offset-4">
                            <br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-mobile"></i> Validate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </center>
</div>
@endsection