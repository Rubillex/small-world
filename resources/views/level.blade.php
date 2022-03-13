@extends('layouts.app')
@section('content')
    <level-component :data='@json($data)'></level-component>
@endsection
