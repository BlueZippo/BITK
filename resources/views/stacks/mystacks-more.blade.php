			@if (count($mystacks) > 0)

		        @foreach($mystacks as $stack)

		            <div class="col-md-2" id="stack{{$stack['id']}}">

		                @include('stacks.dashboard-box')

		            </div>



		        @endforeach

		    @endif

			
