<div class="people-box">
	<div class="header">

	</div>

	<div class="row">

		<div class="col-md-6">

			<div class="author user-ctrl">
		      <div class="avatar">
		        @if ($person->photo)
		          <img src="{{$person->photo}}">
		        @else
		          <div class="inner">
		            {{ render_initials( $person->name ? $person->name : $person->email   ) }}
		          </div>
		        @endif
		      </div>      
		    </div>	

		    <div class="name">{{$person->name}}</div>

		</div>
		
		<div class="col-md-6">    


			<a data-action="follow" data-id="{{$person->id}}" class="follow-people-button">Follow</a>

		</div>

	</div>

</div>
