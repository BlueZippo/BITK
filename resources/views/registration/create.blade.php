<<<<<<< HEAD
@extends ('layouts.master')

@section('content')

	<div class="row">
		<div class="col-sm-8">
			<h1>Register</h1>
			<form method="POST" action="/register">
				{{ csrf_field() }}

				<div class="form-group">
					
					<label for="name">Name:</label>

					<input type="text" class="form-control" id="name" name="name" required>

				</div>

				<div class="form-group">
					
					<label for="email">Email:</label>

					<input type="email" class="form-control" id="email" name="email" required>

				</div>

				<div class="form-group">
					
					<label for="password">Password:</label>

					<input type="password" class="form-control" id="password" name="password" required>

				</div>

				<div class="form-group">
					
					<label for="password_confirmation">Password Confirmation:</label>

					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>

				</div>

				<div class="form-group">
					
					<button type="submit" class="btn btn-primary">Register</button>

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

=======
@extends ('layouts.master')

@section('content')

	<div class="row">
		<div class="col-sm-8">
			<h1>Register</h1>
			<form method="POST" action="/register">
				{{ csrf_field() }}

				<div class="form-group">
					
					<label for="name">Name:</label>

					<input type="text" class="form-control" id="name" name="name" required>

				</div>

				<div class="form-group">
					
					<label for="email">Email:</label>

					<input type="email" class="form-control" id="email" name="email" required>

				</div>

				<div class="form-group">
					
					<label for="password">Password:</label>

					<input type="password" class="form-control" id="password" name="password" required>

				</div>

				<div class="form-group">
					
					<label for="password_confirmation">Password Confirmation:</label>

					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>

				</div>

				<div class="form-group">
					
					<button type="submit" class="btn btn-primary">Register</button>

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

>>>>>>> e236547ae1352cda20a82d8e253db6ee8eb6ec3c
@endsection