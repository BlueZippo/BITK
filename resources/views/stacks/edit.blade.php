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

    <div class="row">
        
        <div class="col-sm-12">
            
            <h1>Edit Stack</h1>
            
            <hr />

            {!! Form::open(['action' => ['StacksController@update', $stack->id],  'method' => 'POST']) !!}               

                {{Form::hidden('video_id', 0)}}
                {{Form::hidden('title', $stack->title)}}
                {{Form::hidden('content', $stack->content)}}
                {{Form::hidden('status_id', $stack->status_id)}}

                <div class="dotted">

                    <div class="row">

                        <div class="col-md-7">

                            <div class="form-group">

                                <div class="dotted" data-field="title">
                                    <div class="content" contenteditable="false">{{$stack->title}}</div>
                                    <a class="fa fa-edit"></a>
                                </div>

                                

                            </div> 

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="dotted" data-field="topics">

                                        <div class="content categories-content" contenteditable="false">{{$stack_categories}}</div>
                                        <a class="fa fa-edit"></a>

                                        @include('stacks.create-categories')

                                    </div>    

                                </div>
                                
                                <div class="stack-meta col-md-6">    


                                    <div class="switch @if($stack->status_id == 1) switchOn @endif" ></div>

                                    <div class="meta-data text-right">Last updated: {{$last_updated}} <a class="fa fa-comment"></a> English <a class="fa fa-plus-circle"></a></div>

                                </div>    

                            </div> 

                            <hr />

                            <div class="form-group">

                                <div class="dotted" data-field="content">
                                    <div class="content" contenteditable="false">{{$stack->content}}</div>
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

        </div>
        
    </div>

@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection