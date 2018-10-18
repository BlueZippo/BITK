@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-12">
            
			<h1>Edit Stack</h1>
            
            <hr />

            {!! Form::open(['action' => ['StacksController@update', $stack->id], 'method' => 'POST']) !!}


                <div class="row">

                    <div class="col-md-7">                    

                        {{Form::hidden('id', $stack->id)}}
                        {{Form::hidden('video_id', $stack->video_id)}}

                        <div class="form-group">

                            {{Form::label('title', 'Title')}}
                            {{Form::text('title', $stack->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}

                            <span class="small">Last updated: {{date("M d, Y", strtotime($stack->updated_at))}}</span>

                        </div>  

                        

                        <div class="form-group">

                            {{Form::label('content', 'Content')}}
                            {{Form::textarea('content', $stack->content, ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

                        </div>    

                         @include('stacks.meta-author')

                    </div>

                    <div class="col-md-5">

                        @include('stacks.youtube')

                    </div>    

                </div>    

               

                @php $linkCounter = 0; @endphp
                
                @include('stacks.links')  

                @include('stacks.add-link-form')

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>



@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection

