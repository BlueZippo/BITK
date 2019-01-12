@php 

if ($ss == 1):
	$class = 'square-1';
elseif ($ss == 2):
	$class = 'square-2';
elseif ($ss > 2):
	$class = 'square-3';
else:
	$class = 'square-0';
endif;


@endphp

<div class="{{$class}}">
	@foreach($collection->stacks as $stack)
		@if ($stack->media_type == 'image')
			<div class="stack-image" style="background-image:url({{$stack->video_id}})">
				
			</div>
		@endif
	@endforeach
</div>