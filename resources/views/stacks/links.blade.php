<div class="links-nav" role="tablist">

    <a class="all">All</a>
    
    <a class="top-three">Top Three</a>

    @foreach($medias as $media)

       <a class="category-button @if($media->id == $media_id) active @endif" data-category="{{$media->id}}"  data-toggle="tab" role="tab">{{$media->media_type}}</a>

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
