<div class="real-time-results tile">

	@foreach($stacks as $stack)

		<div class="single-stack-wrapper stack{{$stack['id']}}">

	        @include('stacks.box')

	   	</div>

	@endforeach

</div>