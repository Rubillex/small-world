@extends('layouts.app')

@section('content')
<template-component :data='@json($data)'></template-component>
@endsection
