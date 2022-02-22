@extends('layouts.app')
    @section('content')
        <start-game-component :data='@json($data)'></start-game-component>
    @endsection
