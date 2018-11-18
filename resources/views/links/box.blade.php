<div class="single-link">

	<div class="image"><img src="{{$link['image']}}"></div>

	<div class="inner">

		<div class="title"><a href="{{$link['link']}}" target="_blank">{{$link['title']}}</a></div>

		<div class="divider"></div>

		<div class="link-meta">

			<div class="row">

				<div class="col-md-9">

					{{$link['media_type']}}

				</div>

				<div class="col-md-3 text-right">

					<a class="link-comment-button" data-id="{{$link['id']}}"><i class="fa fa-comment"></i> @if($link['comments'] > 0) {{$link['comments']}} @endif</a>

				</div>

			</div>

		</div>

	</div><!-- .inner -->

</div>
