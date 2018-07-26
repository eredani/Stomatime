@extends('layouts.viewcabs')
@section('content')
<script>
window.config={
  ID: {!! $info->id !!},
};
</script>
<div id="reactview"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgvKK8zIvqhXuGnv9uYbiIT_biwXPg4YM"></script>
@endsection
