@extends('layouts.viewcabs')
@section('content')
<script>
window.config={
  ID: {!! $info->id !!},
};
</script>
<div id="reactview"></div>
<script>
      if('{!! $info->tawk !!}' !==null)
    {

       
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='{!! $info->tawk !!}';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
      
    }
  </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgvKK8zIvqhXuGnv9uYbiIT_biwXPg4YM"></script>
@endsection
