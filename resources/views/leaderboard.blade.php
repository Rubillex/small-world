@extends('layouts.app')
@section('content')
    <leader-board-component :data='@json($data)'></leader-board-component>
@endsection
