
    <div class="tab-pane fade show active" id="layout-tabbed" role="tabpanel" aria-labelledby="nav-layout-tabbed">

        <div class="links-nav" role="tablist">

            <a class="all active">All</a>

            <a class="top-three">Top Three</a>

            @foreach($medias as $media)

                @php

                $counter = 0;

                @endphp

                @foreach($links as $link)

                    @if ($media->id == $link['media_id'])

                        @php $counter++ @endphp


                    @endif

                @endforeach

               <a class="category-button" data-category="{{$media->id}}"  data-toggle="tab" role="tab">

                    {{$media->media_type}}

                    @if ($counter > 0)

                    <span>{{$counter}}</span>

                    @endif

               </a>

            @endforeach
        </div>

        <div class="tab-content tabbed-view">

            <div class="row stack-links">

                @php $linkCounter = 0 @endphp

                @foreach($links as $link)

                    {{--@php var_dump($link) @endphp--}}

                     <div class="col-md-3 category{{$link['media_id']}}" id="link{{$linkCounter}}">
                        <div class="single-link">
                            <input type="hidden" name="links[{{$linkCounter}}][id]" value="{{$link['id']}}">
                            <input type="hidden" name="links[{{$linkCounter}}][url]" value="{{$link['link']}}">
                            <input type="hidden" name="links[{{$linkCounter}}][title]" value="{{$link['title']}}">
                            <input type="hidden" name="links[{{$linkCounter}}][description]" value="{{$link['description']}}">
                            <input type="hidden" name="links[{{$linkCounter}}][image]" value="{{$link['image']}}">
                            <input type="hidden" name="links[{{$linkCounter}}][media_id]" value="{{$link['media_id']}}">
                            <div class="image"><img src="{{$link['image']}}"></div>
                            <div class="title">{{$link['title']}}</div>
                            <div class="link-hover"><a data-id={{$linkCounter}} onClick="$('#link{{$linkCounter}}').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>
                        </div>
                    </div>

                    @php $linkCounter++ @endphp

                @endforeach


            </div>


        </div>

    </div><!-- #layout-tabbed -->
