@extends('layouts.app')
@section('content')
    <question-component :data='@json($data)'></question-component>
@endsection
