@extends('layouts.base')

@section('content')
    <submit-page></submit-page>
@endsection

@section('vue')
    <script>
        window.vueData = {!! json_encode($data)     !!}
    </script>
@endsection
