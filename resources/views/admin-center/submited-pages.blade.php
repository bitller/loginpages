@extends('layouts.base')
@section('content')
    <submited-pages-page></submited-pages-page>
@endsection

@section('vue')
    <script>
        window.vueData = {!! json_encode($data) !!}
    </script>
@endsection
