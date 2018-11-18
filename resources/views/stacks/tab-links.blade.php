
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
                        @include('links.box')
                    </div>

                    @php $linkCounter++ @endphp

                @endforeach


            </div>


        </div>

    </div><!-- #layout-tabbed -->
