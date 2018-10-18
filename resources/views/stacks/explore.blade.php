@extends ('layouts.master')

@section('content')

    <h2><a href="/stacks/explore">Explore</a></h2>            

    <hr />

    <div class="row">

        <div class="col-md-3">

            @include('stacks.media-type')


        </div>
        
        <div class="col-md-9">    

            <div class="row">

                @foreach($stacks as $stack)

                <div class="col-md-4">

                    <div class="inner-wrap">

                        <div class="featured-image">

                            @if ($stack['image'])  

                                 <img src="http://img.youtube.com/vi/{{$stack['image']}}/hqdefault.jpg">

                            @else


                                 <img src="/images/youtube-image.png">


                            @endif


                        </div>    

                        <div class="stack-content">

                            <div class="title">

                                <a href="/stacks/{{$stack['id']}}/dashboard">

                                    {{$stack['title']}}

                                </a>    

                            </div>   

                            <div class="meta-category">


                                <div class="categories">{{$stack['categories']}}</div>

                                <div class="date">{{$stack['updated_at']}}</div>


                            </div>    


                            <div class="author user-ctrl"> 


                                <div class="avatar">

                                    @if ($stack['author']['photo'])

                                        <img src="{{$stack['author']['photo']}}">

                                    @else


                                        <div class="inner">

                                            {{ render_initials( $stack['author']['name'] ? $stack['author']['name'] : $stack['author']['email']   ) }}

                                        </div>    


                                    @endif


                                </div>
                                
                                by: {{$stack['author']['name']}}    


                            </div>  


                            <div class="stack-footer">  


                                <a class="follow-button" data-id="{{$stack['id']}}"><i class="fa fa-plus"></i> Save</a>


                            </div>    

                        </div>    


                    </div>

                </div>


                @endforeach

            </div>
            
         </div>       
        
        
    </div>    
   

@endsection