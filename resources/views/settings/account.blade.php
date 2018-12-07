<div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
  <h5>ACCOUNT</h5>

  <ul>
  	

  	@include('settings.account-emails')
  	@include('settings.account-password')

  	<li class="row">
  		<span class="col-md-4">
  			Logout
  		</span>
  		<span class="col-md-4">  			
  			<a>Logout of all other browsers</a>
  		</span>
  	</li>  	

  	<li class="row">
  		<span class="col-md-4">
  			Connected Accounts
  		</span>
  		<span class="col-md-8 text-right">  			
  			<a>Learn More</a>
  		</span>
  	</li>  	

  	<li class="row">
  		<span class="col-md-4">
  			<i class="fa fa-twitter"></i> Twitter
  		</span>
  		<span class="col-md-4">  			
  			<a>Connect Twitter Account</a>
  		</span>
  	</li>  	

  	<li class="row">
  		<span class="col-md-4">
  			<i class="fa fa-facebook"></i> Facebook
  		</span>
  		<span class="col-md-4">  			
  			<a>Connect Facebook Account</a>
  		</span>
  	</li>  	

  	<li class="row">
  		<span class="col-md-4">
  			<i class="fa fa-linkedin"></i> Linkedin
  		</span>
  		<span class="col-md-4">  			
  			<a>Connect Linkedln Account</a>
  		</span>
  	</li>  	

  </ul>
</div>


<div class="modal" tabindex="-1" role="dialog" id="enterPasswordModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enter Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>For security purposes, please enter your password in order to continue.</p>
        <p><input type="password" class="form-control" name="enterpassword" value="" placeholder="Password"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="primaryPasswordModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enter Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>For security purposes, please enter your password in order to continue.</p>
        <p><input type="password" class="form-control" name="enterpassword" value="" placeholder="Password"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="confirmEmailModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
