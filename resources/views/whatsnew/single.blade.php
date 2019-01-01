@extends('layouts.master')

@section('content')

<h1><i class="fa fa-gift"></i> {{$val['title']}} <small>{{$val['subtitle']}}</small></h1>

<div class="whats-new-body">
{!! $val['content'] !!}
</div>

@endsection