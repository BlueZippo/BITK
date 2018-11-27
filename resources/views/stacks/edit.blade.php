@extends ('layouts.master')

@section('style')


<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ asset('css/create-stack.css') }}" rel="stylesheet">

@endsection

{{--@section('sidebar')--}}
<!--
<div class="stack-sidebar">

    <a class="chats"><i class="fa fa-comments"></i></a>

    <a class="views"><i class="fa fa-bars"></i> change view</a>

    <a class="cancel" href="/dashboard/"><i class="fa fa-times-circle"></i> cancel</a>

    <a class="save"><i class="fa fa-edit"></i> save</a>

</div>
-->
{{--@endsection--}}


@section('content')

<div class="dashboard">
    <div class="nav-wrapper">
        @include('pages.nav')
    </div>
</div>

    <div class="row edit-stack">

        <div class="col-sm-12">

            <div class="page-title-row">

                <h1>Edit <span>Stack</span></h1>

                <div class="stack-controls">
                    <div class="stack-ctrl-item switch-box" style="display:none;">
                        <div class="switch status @if($stack->status_id == 1) switchOn @endif" >@if($stack->status_id == 1) Published @else Draft @endif</div>
                    </div>
                    <div class="stack-ctrl-item switch-box">
                        <div class="switch public @if($stack->private == 0) switchOn @endif" >@if($stack->private == 1) Private @else Public @endif</div>
                    </div>
                    <div class="stack-ctrl-item back">
                        <svg width="29" height="19" xmlns="http://www.w3.org/2000/svg">
                          <path id="back" d="M27.47 18.785a.598.598 0 0 1-.557-.364c-.07-.164-1.806-4.059-8.297-4.83-1.353-.164-2.972-.248-4.939-.263v4.854a.604.604 0 0 1-.32.535.607.607 0 0 1-.618-.035L.267 10.287a.603.603 0 0 1 0-1.003L12.744.888a.593.593 0 0 1 .619-.03c.2.107.318.31.318.528v4.517c2.713.354 14.39 2.452 14.39 12.284a.604.604 0 0 1-.484.592c-.039.006-.08.006-.118.006z" fill="#20AAF4" fill-rule="nonzero"/>
                        </svg>
                        <span>Back</span>
                    </div>
                    <div class="stack-ctrl-item clone">
                        <svg width="38" height="18" xmlns="http://www.w3.org/2000/svg">
                          <g>
                            <path id="clone" d="M7.875 4.781V0H.844A.842.842 0 0 0 0 .844v16.312c0 .468.376.844.844.844h11.812a.842.842 0 0 0 .844-.844V5.625H8.719a.846.846 0 0 1-.844-.844zm2.25 8.297c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.25c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.531v.281c0 .232-.19.422-.422.422H3.797a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422zM13.5 4.286V4.5H9V0h.214c.225 0 .44.088.598.246l3.442 3.445a.841.841 0 0 1 .246.595zM31.746 4.781V0h-7.031a.842.842 0 0 0-.844.844v16.312c0 .468.376.844.844.844h11.812a.842.842 0 0 0 .844-.844V5.625H32.59a.846.846 0 0 1-.844-.844zm2.25 8.297c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.25c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422v.281zm0-2.531v.281c0 .232-.19.422-.422.422h-5.906a.423.423 0 0 1-.422-.422v-.281c0-.232.19-.422.422-.422h5.906c.232 0 .422.19.422.422zm3.375-4.011V4.5h-4.5V0h.215c.225 0 .439.088.597.246l3.442 3.445a.841.841 0 0 1 .246.595zM21.34 9l-4.852 4.184V4.816z" fill="#1DA1F2" fill-rule="nonzero" />
                          </g>
                        </svg>
                        <span>Clone</span>
                    </div>
                    <div class="stack-ctrl-item trash">
                        <i class="fas fa-trash-alt"></i>
                        <span>Trash</span>
                    </div>
                    <div class="stack-ctrl-item save">
                        <i class="fas fa-save"></i>
                        <span>Save</span>
                    </div>
                    <div class="stack-ctrl-item preview">
                        <i class="fas fa-eye"></i>
                        <span>Preview</span>
                    </div>
                </div>

            </div>

            <hr />

            <form method="POST" action="/stacks/{{$stack->id}}/update">

                {{Form::hidden('video_id', $stack->video_id)}}
                {{Form::hidden('media_type',$stack->media_type)}}
                {{Form::hidden('title', $stack->title)}}
                {{Form::hidden('private', $stack->private)}}
                {{Form::hidden('content', $stack->content)}}
                {{Form::hidden('status_id', 1)}}
                {{Form::hidden('id', $stack->id)}}

                {{Form::hidden('active_media_id', $active_media_id)}}

                 {{ csrf_field() }}

                <div class="dotted">

                    <div class="row">

                        <div class="col-md-7">

                            <div class="form-group">

                                <div class="dotted" data-field="title">
                                    <div class="content" contenteditable="true">{{$stack->title}}</div>
                                    <a class="fa fa-edit"></a>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="dotted" data-field="topics">

                                        <div class="content categories-content" contenteditable="true">{{$stack_categories}}</div>
                                        <a class="fa fa-edit"></a>

                                        @include('stacks.create-categories')

                                    </div>

                                </div>

                                <div class="stack-meta col-md-6">

                                    <div class="meta-data text-right">
                                        <p>Updated: {{$last_updated}}</p>
                                        <p class="comments"><i class="fas fa-comment-dots"></i> 0 Comments</p>
                                    </div>

                                </div>

                            </div>

                            <hr />

                            <div class="form-group">

                                <div class="dotted" data-field="content">
                                    <div class="content" contenteditable="true">{{$stack->content}}</div>
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





            </form>


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

                        {{Form::select('media_types', ['youtube' => 'Youtube', 'image' => 'Image', 'upload' => 'Upload Image'], 0, ['class' => 'form-control'])}}

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
