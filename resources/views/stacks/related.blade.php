<div class="stack-panel">

	<div class="panel-heading"><h3>Related <span>Stacks</span></h3></div>

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
