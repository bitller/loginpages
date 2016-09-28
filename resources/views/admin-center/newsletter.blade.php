@extends('layouts.base')
@section('content')
    <newsletter-page></newsletter-page>
@endsection

@section('vue')
    <script>
        window.vueData = {!! json_encode($data) !!}
    </script>
@endsection
