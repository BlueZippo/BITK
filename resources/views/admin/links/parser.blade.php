@extends('layouts.master')


@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Link Parser</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-success" href="{{ route('admin.links.create') }}"> Add Domain</a>

        </div>

    </div>

</div>




<table class="table table-bordered">

 <thead>

   <tr>

     <th class="text-center">No</th>

     <th>Domain</th>

    <th>Title</th>

    <th>Description</th>

    <th>Image</th>

    <th>Default Category</th>   

    <th>Category Lookup</th>

    <th width="280px" class="text-center">Action</th>

   </tr>

</thead>

 <tbody>

    @php $counter = 0; @endphp

    @foreach($links as $link)

    <tr id="link{{$link->id}}">

      <td class="text-center">{{++$counter}}</td>

      <td>{{$link->domain}}</td>

      <td>{{$link->title}}</td>

      <td>{{$link->description}}</td>

      <td>{{$link->image}}</td>

      <td>@if($link->media_type){{$link->media_type->media_type}}@endif</td>

      <td>{{$link->lookup}}</td>

      <td class="text-center">

        <a href="/admin/links/{{$link->id}}/edit" class="btn btn-primary">Edit</a>

      </td>


    </tr> 


    @endforeach

 </tbody>
 

</table>




@endsection