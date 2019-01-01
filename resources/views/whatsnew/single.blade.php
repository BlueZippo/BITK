@extends('layouts.master')

@section('content')

<h1><i class="fa fa-gift"></i> {{$val['title']}} </h1>

<div class="whats-new-body">
{{html_entity_decode($val['content'])}}
</div>

@endsection