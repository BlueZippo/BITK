<div class="modal fade" id="updateProfileBackgroundModal" tabindex="-1" role="dialog" aria-labelledby="updateProfileBackgroundModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateProfileBackgroundModal">Upload Profile Background</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">          

        <form id="upload-background-form" action="/users/profile/background" method="post" enctype="multipart/form-data">      

          @if ($user->background)
            <img id="background-img" src="{{$user->background}}">
          @else
            <img id="background-img" src="/images/no-available-image.png">
           @endif

          <div class="form-group">
              {!! Form::file('background', array('class' => 'image', 'id' => 'background')) !!}
          </div>      
        </form>

        <div class="alert alert-info" id="loading" style="display: none;" role="alert">
          Uploading image...
          <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
              </div>
          </div>
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary upload-background-button">Update Profile Background</button>
      </div>
    </div>
  </div>
</div>