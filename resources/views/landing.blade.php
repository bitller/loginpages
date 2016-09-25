@extends('layouts.base')
@section('content')
    <landing-page></landing-page>
@endsection
@section('vue')
<script>
window.vueData = {!! json_encode($data) !!}
</script>
@endsection
