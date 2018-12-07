<li class="row">
  		<span class="col-md-4">
  			Primary Email
  		</span>
  		<span class="col-md-8">
  			{{$user->email}}<br />
  			<input type="hidden" name="primary_email">
  			<input type="hidden" name="primary_id">
  			@foreach($emails as $email)
	  			<div  id="email{{$email->id}}">
	  				<a class="delete-email" data-id="{{$email->id}}" data-email="{{$email->email}}"><i class="fa fa-times-circle"></i></a> {{$email->email}} 
	  					@if ($email->confirmed == 1) 
	  						<a class="set-as-primary" data-email="{{$email->email}}" data-id="{{$email->id}}">Set As Primary</a><br /> 
	  					@else 
	  						<a class="confirm-email" data-email="{{$email->email}}" data-id="{{$email->id}}">Confirm Email</a><br />
	  					@endif
	  			</div>
  			@endforeach
  			<div class="add-email">
  				<div class="form-group row">
  					<div class="col-md-8">
  						<input type="text" class="form-control" name="email" placeholder="name@example.com">
  					</div>
  					<div class="col-md-4">
  						<button class="btn btn-primary">Add Email</button>
  					</div>
  				</div>
  			</div>
  			<a class="add-another-email">Add Another Email Address</a>  			
  		</span>
  	</li>  	