<div class="single-link">

	<div class="image"><img src="{{$link['image']}}"></div>

	<div class="title">{{$link['title']}}</div> 

	<div class="link-meata">                                   

		<div class="row">

			<div class="col-md-6">

				<a href="{{$link['link']}}" target="_blank">{{$link['domain']}}</a>

			</div>	


			<div class="col-md-6">

				{{$link['date']}}

			</div>	


		</div>	

		<div class="row">

			<div class="col-md-6">

				<a href="/stacks/{{$category->id}}/category">{{$category->cat_name}}</a>

			</div>	


			<div class="col-md-6">

				

			</div>	


		</div>	

	</div> 

</div>		