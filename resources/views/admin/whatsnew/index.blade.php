@extends('layouts.master')

@section('scripts')

<script>

$(document).on('click', '.whatsnew-delete', function()
{
    var id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
        {
            url: '/admin/whatsnew/delete',
            data: 'id=' + id,
            type: 'post',
            success: function()
            {
                $('#row' + id).remove();
            }
        }
    )

    
    return false;
    
});

</script>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>What's New</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-success" href="{{ route('admin.whatsnew.create') }}"> Add</a>

        </div>

    </div>

</div>




<table class="table table-bordered">

 <thead>

   <tr>

    <th class="text-center">No</th>

    <th>Title</th>

    <th>Type</th>

    <th>Date Published</th>   

    <th>Author</th>

    <th width="280px" class="text-center">Action</th>

   </tr>

</thead>

 <tbody>

    @php $counter = 0; @endphp

    @foreach($results as $result)

    <tr id="row{{$result->id}}">

      <td class="text-center">{{++$counter}}</td>

      <td>{{$result->title}}</td>

      <td>{{$result->type}}</td>

      <td>{{$result->published_date}}</td>

      <td>{{$result->user->name}}</td>

      <td class="text-center">

        <a href="/admin/whatsnew/{{$result->id}}/edit" class="btn btn-primary">Edit</a>

        <a href="" class="btn btn-danger whatsnew-delete" data-id={{$result->id}}>Delete</a>

      </td>


    </tr> 


    @endforeach

 </tbody>
 

</table>




@endsection