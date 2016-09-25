@extends('layouts.base')
@section('content')
    <favorites-page></favorites-page>
@endsection

@section('vue')
    <script>
        window.vueData = {!! json_encode($data) !!}
    </script>
@endsection
