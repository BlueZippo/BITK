<div class="stack-author">

	<div class="row author">

		<div class="col-md-6 user">

			<div class="created"><p>Created By:</p></div>

			<div class="user-ctrl">
				<div class="avatar">
					@if ($user->photo)
						<img class="author-photo" src="{{$user->photo}}">
					@else
						<div class="inner">
							{{ render_initials( isset($user->name) ? $user->name : $user->email) }}
						</div>
					@endif
				</div>
			</div>

			<span class="author-name">{{$user->name}}</span>

		</div>

		<div class="col-md-6 text-right">

			<div class="likes">

				<a class="upvote"><i class="fas fa-thumbs-up"></i> {{$upvote}}</a>

				<a class="downvote"><i class="fas fa-thumbs-down"></i> {{$downvote}}</a>

			</div>

			<div class="social">

				<a href="#"><i class="fab fa-facebook-square"></i></a>

				<a href="#"><i class="fab fa-twitter"></i></a>

				<a href="#"><i class="fab fa-linkedin"></i></a>

				<a href="#"><i class="fab fa-instagram"></i></a>

				<a href="#"><i class="fab fa-reddit-square"></i></a>

				<a href="#"><i class="fas fa-ellipsis-h"></i></a>

			</div>

		</div>

	</div>

</div>
