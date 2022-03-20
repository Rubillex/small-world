@extends('layouts.app')
@section('content')
    <profile-component :data='@json($data)'></profile-component>
@endsection
