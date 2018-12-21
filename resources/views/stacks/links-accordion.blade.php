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
                                                    <div class="image"><img src="{{$link->get_image($link)}}"></div>
                                                    <div class="title">{{$link['title']}}</div>
                                                    <div class="link-hover"><a data-id={{$linkCounter}} onClick="$('#link{{$linkCounter}}').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>
                                                </div>
                                            </div>                                    

                                        @endif

                                    @endforeach

                                @endif

                                <div class="col-md-3 add-link-button-wrapper">

                                    <a class="add-link-accordion-modal" data-category="{{$media->id}}"><i class="fa fa-plus-circle"></i></a>     

                                    @include('stacks.add-link-accordion-form')                              

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