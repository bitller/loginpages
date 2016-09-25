@extends('layouts.base')
@section('content')
    <random-page><random-page>
@endsection

@section('vue')
    <script>
        window.vueData = {!! json_encode($data) !!}
    </script>
@endsection
