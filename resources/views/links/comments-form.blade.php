<div class="link-comment-form">
	{!! Form::open() !!}     

	<div class="form-group">

		<div class="row">

			<div class="col-md-2 text-center">

				<div class="avatar">

					 @if (Auth::user()->photo)

                    <img src="{{Auth::user()->photo}}">

                    @else

                    <div class="inner">{{ render_initials( isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email ) }}</div>

                    @endif

				</div>	

			</div>
			
			<div class="col-md-10">	

				{{Form::hidden('link_id', $link_id)}}

				{{Form::textarea('comment', '', ['rows' => 1, 'placeholder' => 'Write a comment...', 'class' => 'form-control'])}}

			</div>

		</div>

	</div>	

	

	{!! Form::close() !!}
</div>