@extends('layouts.app')
@section('content')
    <leaderboard-component :data='@json($data)'></leaderboard-component>
@endsection
