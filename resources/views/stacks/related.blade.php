<div class="panel panel-default">

	<div class="panel-heading">Related Stacks</div>

		<div class="panel-body">

			<div class="row">

				@foreach($related as $stack)

					<div class="col-md-3">

						@include('stacks.related-box')

					</div>	

				@endforeach

			</div>

		</div>
		
	</div>

</div>	