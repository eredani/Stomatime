@extends('layouts.app')
@section('content')
<script>
window.config={
  ID: {!! $id !!},
  csrfToken: "{!! csrf_token() !!}"
};
</script>
<div id="reactprogramari"></div>
@endsection
