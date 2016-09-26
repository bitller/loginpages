@extends('layouts.base')
@section('content')
    <users-page></users-page>
@endsection

@section('vue')
    <script>
        window.vueData = {!! json_encode($data) !!}
    </script>
@endsection
