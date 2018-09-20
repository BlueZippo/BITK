@extends ('layouts.master')

@section('content')

	<div class="row">
		<div class="col-sm-8">
			<h1>Sign In</h1>
			<form method="POST" action="/login">
				{{ csrf_field() }}

				<div class="form-group">

					<label for="email">Email:</label>

					<input type="email" class="form-control" id="email" name="email" required>

				</div>

				<div class="form-group">

					<label for="password">Password:</label>

					<input type="password" class="form-control" id="password" name="password" required>

				</div>

				<div class="form-group">

					<button type="submit" class="btn btn-primary">Sign In</button>

					<a class="btn btn-link" href="{{ route('password.request') }}">
							Forgot Your Password?
					</a>

				</div>

				@include ('layouts.errors')

			</form>

		    <div class="form-group">
		        <div class="col-md-6 col-md-offset-4">
		            <a href="{{ url('/auth/facebook') }}" class="btn btn-outline-secondary"><i class="fa fa-facebook"></i>  Facebook</a>
		           	<a href="{{ url('/auth/google') }}" class="btn btn-outline-secondary"><i class="fa fa-google"></i>  Google</a>
		           	<a href="{{ url('/auth/linkedin') }}" class="btn btn-outline-secondary"><i class="fa fa-linkedin"></i>  LinkedIn</a>
		        </div>
		    </div>


		</div>
	</div>

@endsection
