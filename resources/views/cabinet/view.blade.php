@extends('layouts.app')

@section('content')
    <script>
        window.config={
            ID: {!! $info->id !!},
            myID: {!! $id !!},
            csrfToken: "{!! csrf_token() !!}"
        };
    </script>
<script>
    window.setTimeout(function () {
        $(".alert-info").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);
</script>
@endsection
