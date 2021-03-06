<div class="dragdrop-target">

	<div class="stack-panel my-stacks dragdrop" data-id="dashboard-mystacks">

		<div class="panel-heading"><h3>My <span>Stacks</span></h3></div>

		<div class="panel-body">

			<div class="row my-links">

				<div class="col-md-2">
			        <div class="inner-wrap dash-stack-tile create-stack">
						<div class="stack-content">
							<a href="/stacks/create" target="_self"><i class="fas fa-plus-circle"></i><p>Create a Stack</p></a>
						</div>
			        </div>
			    </div>

				@if (count($mystacks) > 0)

			        @foreach($mystacks as $stack)

			            <div class="col-md-2" id="stack{{$stack['id']}}">

			                @include('stacks.dashboard-box')

			            </div>



			        @endforeach

			    @endif


				<!-- <div class="col-md-2">
					<div class="inner-wrap dash-stack-tile create-stack reminder">
						<div class="stack-content">
							@include('stacks.reminder')
						</div>
					</div>
				</div> -->

			</div>

			<div class="row">

				<div class="col-md-12 text-center">

						<a class="view-all btn btn-primary show-more" data-page="1">Show More</a>

				</div>

			</div>

		</div>

	</div>

</div>
