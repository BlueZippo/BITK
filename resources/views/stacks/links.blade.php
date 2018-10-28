<ul class="nav nav-tabs links" role="tablist">

    <li><a class="nav-link">All</a></li>
    
    <li><a class="nav-link">Top Three</a></li>

    @foreach($medias as $media)

        <li>
            <a class="nav-link" data-category="{{$media->id}}" data-toggle="tab" href="#category{{$media->id}}" role="tab">{{$media->media_type}}</a>
        </li>

    @endforeach
</ul>

<div class="tab-content">
    
    <div class="row stack-links">   

        @php $linkCounter = 0 @endphp

        @foreach($links as $link)               

             <div class="col-md-3" id="link{{$linkCounter}}">
                <div class="single-link">
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
