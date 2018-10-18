@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-12">
            
			<h1>Create A Stack</h1>
            
            <hr />

            {!! Form::open(['action' => 'StacksController@store', 'method' => 'POST']) !!}               

                {{Form::hidden('video_id', 0)}}

                <div class="row">

                    <div class="col-md-7">

                        <div class="form-group">

                            {{Form::label('title', 'Title')}}
                            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}                    

                        </div>  

                       

                        <div class="form-group">

                            {{Form::label('content', 'Content')}}
                            {{Form::textarea('content', '', ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

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

                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection