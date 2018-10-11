<div class="youtube">

  @if (old('video_id'))

    @include('stacks.youtube-frame');

  @elseif ($stack->video_id)  

    @include('stacks.youtube-frame2');  

  @else

  <a class="click-here"  data-toggle="modal" data-target="#youtubeModal"></a>

  @endif

</div>

<div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Youtube URL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{Form::text('youtube', '', ['class' => 'form-control', 'placeholder' => 'Enter Youtube URL'])}}   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>