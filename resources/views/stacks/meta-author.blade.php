<div class="stack-author">

	<div class="row author">

		<div class="col-md-6 user">

			<div class="created"><p><span>Created by:</span></p></div>

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

			<a class="upvote">Upvote | {{$upvote}}</a>

			<a class="downvote">Downvote</a>

			<div class="social">

				<a class="fa fa-facebook-square"></a>

				<a class="fa fa-twitter"></a>

				<a class="fa fa-google-plus-circle"></a>

				<a class="fa fa-reddit-alien"></a>

				<a class="">...</a>

			</div>


		</div>

	</div>

</div>
