<div class="row parking-container">

						<div class="col-md-2 link-image">

							<img src="{{$link->image}}">

						</div>

						<div class="col-md-10">

							<div class="link-data">

								<h3><a href="{{$link->link}}" target="_blank">{{$link->title}}</a></h3>

								<div class="host">

									{{$link->get_host($link->link)}}

								</div>

								<div class="meta small">

									<a class="edit-link" data-id={{$link->id}}>Edit</a> | <a class="delete-link" data-id="{{$link->id}}">Delete</a>

								</div>

							</div>

						</div>

					</div>
