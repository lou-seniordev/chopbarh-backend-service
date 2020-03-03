@extends('layouts.app')

@section('content')
    <a href="{{ route('players') }}">Players</a> <br/> <br/>

    <a href="{{ route('super_agent/list') }}">Super Agents List</a> <br/>
    <a href="{{ route('super_agent/upload') }}">Upload Super Agent CSV</a> <br/>
@endsection