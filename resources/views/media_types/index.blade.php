@extends('layouts.master')


@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Media Type</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-success" href="{{ route('media_types.create') }}"> Add Media Type</a>

        </div>

    </div>

</div>



<table class="table table-bordered">

 <tr>

   <th>No</th>

   <th>Media Type</th>

   <th width="280px">Action</th>

 </tr>

 @foreach ($medias as $key => $media)

  <tr>

    <td>{{ ++$i }}</td>

    <td>{{ $media->media_type }}</td>

    
    <td>

       <a class="btn btn-primary" href="{{ route('media_types.edit',$media->id) }}">Edit</a>

        {!! Form::open(['method' => 'DELETE','route' => ['media_types.destroy', $media->id],'style'=>'display:inline']) !!}

            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

        {!! Form::close() !!}

    </td>

  </tr>

 @endforeach

</table>




@endsection