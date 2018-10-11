<div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="addLinkModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLinkModal">Add Link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="well links-container">

            <div class="add-link">

              
                <div class="form-group">

                    {{Form::label('link_url', 'Pasted Link')}}
                    {{Form::text('link_url', '', ['class' => 'form-control', 'placeholder' => 'Enter the link here....'])}}

                    {{Form::hidden('link_category', 0)}}

                </div>

                <div class="row">

                    <div class="col-md-4">

                        Link Image:

                        <span class="link-image"><img src="/images/no-available-image.png"></span>

                    </div>

                    <div class="col-md-8">

                        <div class="form-group">

                            {{Form::label('link_title', 'Link Title')}}
                            {{Form::text('link_title', '', ['class' => 'form-control', 'placeholder' => 'Enter the link title here....'])}}

                        </div>

                        <div class="form-group">

                            {{Form::label('link_description', 'Link Description')}}
                            {{Form::textarea('link_description', '', ['class' => 'form-control', 'placeholder' => 'Enter the link description here....'])}}

                        </div>


                    </div>

                </div>                

            </div>

        </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-link-button">Add Link</button>
      </div>
    </div>
  </div>
</div>

