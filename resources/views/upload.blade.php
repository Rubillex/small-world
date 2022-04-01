@extends('layouts.app')
@section('content')
    <upload-image-component :data='@json($data)'></upload-image-component>
@endsection
