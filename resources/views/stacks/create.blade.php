@extends ('layouts.master')

@section('style')



<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> 
<link href="{{ asset('css/create-stack.css') }}" rel="stylesheet">

@endsection

@section('content')

	<div class="row">
        
		<div class="col-sm-12">
            
			<h1>Create A Stack</h1>
            
            <hr />

            {!! Form::open(['action' => 'StacksController@store', 'method' => 'POST']) !!}               

                {{Form::hidden('video_id', 0)}}
                {{Form::hidden('title', '')}}
                {{Form::hidden('content', '')}}
                {{Form::hidden('status_id', 0)}}

                <div class="dotted">

                    <div class="row">

                        <div class="col-md-7">

                            <div class="form-group">

                                <div class="dotted" data-field="title">
                                    <div class="content" contenteditable="false">enter title...</div>
                                    <a class="fa fa-edit"></a>
                                </div>

                                

                            </div> 

                            <div class="stack-meta">

                                <div class="switch"></div>

                                <div class="meta-data text-right">Last updated: {{$last_updated}} <a class="fa fa-comment"></a> English <a class="fa fa-plus-circle"></a></div>

                            </div> 

                            <hr />

                            <div class="form-group">

                                <div class="dotted" data-field="content">
                                    <div class="content" contenteditable="false">enter description...</div>
                                    <a class="fa fa-edit"></a>
                                </div>

                                

                            </div>  

                            @include('stacks.meta-author')   

                        </div>
                        
                        <div class="col-md-5">    

                             @include('stacks.youtube')

                        </div>
                        
                    </div>

                </div>    

                @php $linkCounter = 0; @endphp    

                

                @include('stacks.links')  

                

                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection