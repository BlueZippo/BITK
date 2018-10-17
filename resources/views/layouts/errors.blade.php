<<<<<<< HEAD
@if (count($errors))

	<div class="form-group">
		<div class="alert alert-danger">

			<ul>

				@foreach ($errors->all() as $error)

					<li>{{ $error }}</li>

				@endforeach

			</ul>

		</div>
	</div>

=======
@if (count($errors))

	<div class="form-group">
		<div class="alert alert-danger">

			<ul>

				@foreach ($errors->all() as $error)

					<li>{{ $error }}</li>

				@endforeach

			</ul>

		</div>
	</div>

>>>>>>> e236547ae1352cda20a82d8e253db6ee8eb6ec3c
@endif