<div class="nav">
	
	<ul>

		@foreach($medias as $media)


			<li>
				
				<a href="/stacks/{{$media->id}}/category">{{$media->cat_name}}</a>

			</li>


		@endforeach

	</ul>	


</div>