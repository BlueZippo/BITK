@extends ('layouts.master')

@section('style')

<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> 
<link href="{{ asset('css/create-stack.css') }}" rel="stylesheet">

@endsection

@section('sidebar')

<div class="stack-sidebar">

    <a class="chats"><i class="fa fa-comments"></i></a>

    <a class="views"><i class="fa fa-bars"></i> change view</a>

    <a class="cancel" href="/dashboard/"><i class="fa fa-times-circle"></i> cancel</a>    

    <a class="save"><i class="fa fa-edit"></i> save</a>    

</div>

@endsection

@section('content')

	<div class="row edit-stack">
        
		<div class="col-sm-12">
            
			<h1>Create A Stack</h1>
            
            <hr />

            {!! Form::open(['action' => 'StacksController@store', 'method' => 'POST']) !!}               

                {{Form::hidden('video_id', 0)}}
                {{Form::hidden('title', '')}}
                {{Form::hidden('content', '')}}
                {{Form::hidden('status_id', 0)}}
                {{Form::hidden('media_type','youtube')}}                
                {{Form::hidden('private', 0)}}
                {{Form::hidden('id', 0)}}
                

                <div class="dotted">

                    <div class="row">

                        <div class="col-md-7">

                            <div class="form-group">

                                <div class="dotted" data-field="title">
                                    <div class="content" contenteditable="true">enter title...</div>
                                    <a class="fa fa-edit"></a>
                                </div>                                

                            </div> 

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="dotted" data-field="topics">

                                        <div class="content categories-content" contenteditable="true">enter a topic...</div>
                                        <a class="fa fa-edit"></a>

                                        @include('stacks.create-categories')

                                    </div>    

                                </div>
                                
                                <div class="stack-meta col-md-6">    

                                    <div class="meta-data text-right">Last updated: {{$last_updated}} <a class="fa fa-comment"></a> English <a class="fa fa-plus-circle"></a></div>

                                    <div class="switcher text-right">

                                        <div class="switch status" >Draft</div>
                                        <div class="switch public" >Public</div>

                                    </div>    
                                    

                                </div>    


                            </div> 

                            <hr />

                            <div class="form-group">

                                <div class="dotted" data-field="content">
                                    <div class="content" contenteditable="true">enter description...</div>
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

                

              

            {!! Form::close() !!}


            <div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Image / Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                    <form id="uploadForm"  enctype="multipart/form-data">
                    
                        {{Form::select('media_type', ['youtube' => 'Youtube', 'image' => 'Image', 'upload' => 'Upload Image'], 0, ['class' => 'form-control'])}}
                        
                        {{Form::text('image', '', ['class' => 'media-field form-control', 'placeholder' => 'Enter Image URL'])}}   
                        
                        {{Form::text('youtube', '', ['class' => 'media-field form-control active', 'placeholder' => 'Enter Youtube URL'])}}   

                        {{ Form::file('upload', array('class' => 'media-field form-control', 'id' => 'upload')) }}
                    

                    </form>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-submit">Submit</button>
                  </div>
                </div>
              </div>
            </div>

		</div>
        
	</div>

@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection