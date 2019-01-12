<div class="collection-single">

	@php $ss = count($collection->stacks) @endphp

	@include('collections.stack-images')

	<div class="collection-title">{{$collection->title}}</div>

	<a href="#">...</a>

	<div class="stack-status">
	

	@if ($ss > 1)
		{{$ss}} Stacks
	@elseif ($ss == 1)
		{{$ss}} Stack
	@else
		No Stack
	@endif
	</div>

</div>