<div class="well">

	<div class="row author">

		<div class="col-md-6">

			Created by:

			<div class="user-ctrl">
				<div class="avatar">
					@if ($user->photo)
						<img class="author-photo" src="/upload/{{$user->photo}}">
					@else
						<div class="inner">
							{{ render_initials( isset($user->name) ? $user->name : $user->email) }}
						</div>
					@endif
				</div>
			</div>	

			{{$user->name}}
		
		</div>

		<div class="col-md-3">

			<a class="btn" href="">Upvote</a> 	
			<a class="btn" href="">Downvote</a>

		</div>	

		<div class="col-md-3">

			<i class="fa fa-facebook-square"></i>

			<i class="fa fa-twitter"></i>

			<i class="fa fa-pinterest"></i>			


		</div>	

	</div>	

</div>