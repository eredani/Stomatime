@extends('layouts.cabinet')

@section('content')
<script>
        window.config={
            ID: {!! $info->id !!},
            csrfToken: "{!! csrf_token() !!}"
        };
</script>
<div id="cabviewprog">
</div>
@endsection