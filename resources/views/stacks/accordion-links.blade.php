    <div class="accordion stack-single">

            <a class="open-all">Open</a> / <a class="close-all">Close All</a>

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

                                    @php $linkCounter = 0; @endphp

                                    @foreach($links as $link)

                                        @if ($link->media_id == $media->id)

                                             <div class="col-md-3" id="link{{$linkCounter}}">
                                                @include('links.box')
                                            </div>

                                            @php $linkCounter++ @endphp

                                        @endif


                                    @endforeach

                                @endif


                            </div>


                        </div>

                    </div>


                </div>

                @php $showPanel = ''; @endphp

                @php $showPanelBtn = ''; @endphp

            @endforeach

            </div>