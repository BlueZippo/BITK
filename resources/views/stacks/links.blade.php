<div class="accordion">

@foreach($categories as $category)

    <div class="card">

        <div class="card-header">

            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="category{{$category->id}}" aria-expanded="true" aria-controls="collapseOne">
                {{$category->cat_name}}
            </button>

        </div>    


        <div class="collapse" id="category{{$category->id}}" data-category="{{$category->id}}">

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

            <div class="row">  


                <a href="" class="add-link"><i class="fa fa-plus-circle"></i></a>    


            </div>    


         </div>   

    
    </div>

@endforeach

</div>