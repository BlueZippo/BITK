<ul class="nav nav-tabs" role="tablist">
    @foreach($medias as $media)

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#category{{$media->id}}" role="tab">{{$media->media_type}}</a>
        </li>

    @endforeach
</ul>

<div class="tab-content">
    @foreach($medias as $media)

        <div class="tab-pane" id="category{{$media->id}}" role="tabpanel"  data-category="{{$media->id}}">

            <div class="container">

                <div class="row stack-links">   

                    @if (count($links))

                        @foreach($links as $link)

                            @if ($link->media_id == $media->id)

                                 <div class="col-md-3 single-link" id="link{{$linkCounter}}">
                                    <input type="hidden" name="links[{{$linkCounter}}][url]" value="{{$link['link']}}">
                                    <input type="hidden" name="links[{{$linkCounter}}][title]" value="{{$link['title']}}">
                                    <input type="hidden" name="links[{{$linkCounter}}][description]" value="{{$link['description']}}">
                                    <input type="hidden" name="links[{{$linkCounter}}][image]" value="{{$link['image']}}">
                                    <input type="hidden" name="links[{{$linkCounter}}][media_id]" value="{{$link['media_id']}}">
                                    <div class="image"><img src="{{$link['image']}}"></div>
                                    <div class="title">{{$link['title']}}</div>
                                    <div class="link-hover"><a data-id={{$linkCounter}} onClick="$('#link{{$linkCounter}}').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>
                                </div>  

                                @php $linkCounter++ @endphp

                            @endif    


                        @endforeach

                    
                    @endif


                </div>

                <div class="row">  

                    <a href="" class="add-link-modal" data-category="{{$media->id}}"  data-toggle="modal" data-target="#addLinkModal"><i class="fa fa-plus-circle"></i></a>    


                </div>    


            </div>

         </div>    

    @endforeach
</div>    
