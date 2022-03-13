@extends('layouts.app')
@section('content')
    <list-of-levels-component :data='@json($data)'></list-of-levels-component>
@endsection
