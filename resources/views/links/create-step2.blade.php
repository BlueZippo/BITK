<div class="step2">

  <div class="form-group">

      {{Form::label('link_media_type', 'Step 2: Select Media Type/Category:')}}  

      {{Form::hidden('media_id', 0)}}

      <ul class="media-types">

        @foreach($medias as $media)

          <li>{{Form::checkbox('', $media->id)}} {{$media->media_type}}</li>

        @endforeach

      </ul>     

  </div>

              
  <div class="form-group">

      {{Form::label('stack_name', 'Step 3: Select Where To Save Your Link:')}}
      {{Form::text('stack_name', '', ['class' => 'stack-name typeahead form-control', 'placeholder' => 'Type to begin searching stacks'])}}
      {{Form::hidden('stack_id', 0)}}

      <span class="small font-italic">By not entering anything, the link will remain in Parking Lot</span>

  </div>


  
                
                
</div>