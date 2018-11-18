<div class="edit-stack-layout-controls"> <!-- https://getbootstrap.com/docs/4.1/components/navs/ -->
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            
            <a class="nav-item nav-link active" id="nav-layout-tabbed" data-toggle="tab" href="#layout-tabbed" role="tab" aria-controls="nav-home" aria-selected="true"><i class="far fa-folder"></i></a>

            <a class="nav-item nav-link" id="nav-layout-accordion" data-toggle="tab" href="#layout-accordion" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-list-ul"></i></a>

        </div>
    </nav>
</div>

<div class="tab-content" id="nav-create-layout">

    <div class="tab-pane fade show active tabbed-panel" id="layout-tabbed" role="tabpanel" aria-labelledby="nav-layout-tabbed">

        <div class="links-nav" role="tablist">

            <a class="all">All</a>

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

               <a class="category-button @if($media->id == $media_id) active @endif" data-category="{{$media->id}}"  data-toggle="tab" role="tab">

                    {{$media->media_type}}

                    @if ($counter > 0)

                    <span>{{$counter}}</span>

                    @endif

               </a>

            @endforeach
        </div>

        <div class="tab-content">

            <div class="row stack-links">

                @php $linkCounter = 0 @endphp

                @foreach($links as $link)

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

                <div class="col-md-3 add-link-button-wrapper">

                    <a class="add-link-modal"><i class="fa fa-plus-circle"></i></a>

                    @include('stacks.add-link-form')

                </div>



            </div>


        </div>

    </div><!-- #layout-tabbed -->

    <div class="tab-pane fade accordion-panel" id="layout-accordion" role="tabpanel" aria-labelledby="nav-layout-accordion">

        <div class="accordion stack-single">

            @php $showPanel = 'show'; @endphp

            @php $showPanelBtn = 'open'; @endphp

            @foreach($medias as $media)

                <div class="card">

                    <div class="card-header">

                        <button class="btn btn-link {{$showPanelBtn}}" type="button" data-toggle="collapse" data-target="#category{{$media->id}}" aria-expanded="true" aria-controls="collapseOne">

                            @if($media->icon)

                            <i class="fa {{$media->icon}}"></i>

                            @endif

                            {{$media->media_type}}


                            @php $counter = 0; @endphp

                            @foreach($links as $link)

                                @if ($link->media_id == $media->id)

                                @php $counter++; @endphp

                                @endif

                            @endforeach

                            @if ($counter > 0)

                                <span>{{$counter}}</span>

                            @endif

                        </button>
                        <div class="divider"></div>

                    </div>

                    <div class="collapse {{$showPanel}}" id="category{{$media->id}}" data-category="{{$media->id}}">

                        <div class="container">

                            <div class="row stack-links">

                                @if (count($links))

                                    @foreach($links as $link)

                                        @if ($link->media_id == $media->id)

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

                                        @endif

                                    @endforeach

                                @endif

                                <div class="col-md-3 add-link-button-wrapper">

                                    <a class="add-link-modal"><i class="fa fa-plus-circle"></i></a>

                                   

                                </div>


                            </div>


                        </div>

                    </div>


                </div>

                @php $showPanel = ''; @endphp

                @php $showPanelBtn = ''; @endphp

            @endforeach

            </div>

    </div>

</div><!-- #nav-create-layout -->
