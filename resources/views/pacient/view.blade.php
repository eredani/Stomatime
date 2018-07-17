@extends('layouts.viewcabs')
@section('content')
<script>
window.config={
  ID: {!! $info->id !!},
};
</script>
<div id="reactview"></div>
@endsection
