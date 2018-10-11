<div class="row stack-links">   

    @if (count($links))

        @foreach($links as $link)

             <div class="col-md-3 single-link" id="link{{$linkCounter}}">
                <input type="hidden" name="links[{{$linkCounter}}][url]" value="{{$link['url']}}">
                <input type="hidden" name="links[{{$linkCounter}}][title]" value="{{$link['title']}}">
                <input type="hidden" name="links[{{$linkCounter}}][description]" value="{{$link['description']}}">
                <input type="hidden" name="links[{{$linkCounter}}][image]" value="{{$link['image']}}">
                <div class="image"><img src="{{$link['image']}}"></div>
                <div class="title">{{$link['title']}}</div>
                <div class="link-hover"><a data-id={{$linkCounter}} onClick="$('#link{{$linkCounter}}').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>
            </div>  

            @php $linkCounter++ @endphp


        @endforeach

    
    @endif


</div>      