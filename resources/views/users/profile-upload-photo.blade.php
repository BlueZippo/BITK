<div class="modal fade" id="updateProfilePhotoModal" tabindex="-1" role="dialog" aria-labelledby="updateProfilePhotoModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateProfilePhotoModal">Upload Profile Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          

        <form id="upload-image-form" action="/users/profile/upload" method="post" enctype="multipart/form-data">      

          @if ($user->photo)
            <img id="preview-img" src="{{$user->photo}}">
          @else
            <img id="background-img" src="/images/no-available-image.png">
           @endif

          <div class="form-group">
              {!! Form::file('image', array('class' => 'image', 'id' => 'file')) !!}
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
        <button type="button" class="btn btn-primary upload-photo-button">Update Profile Photo</button>
      </div>
    </div>
  </div>
</div>