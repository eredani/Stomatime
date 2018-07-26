@extends('layouts.viewcabs')
@section('content')
    <script>
        window.config={
            ID: {!! $info->id !!},
            medicID: {!! $idmedic !!},
        };
    </script>
    <div id="medicreact"></div>
@endsection
