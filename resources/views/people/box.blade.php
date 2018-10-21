<div class="people-box">
	
	<div class="header" @if($person->background) style="background-image:url({{$person->background}})"@endif >

	</div>

	<div class="details">

		<div class="row">

			<div class="col-md-6">

				<div class="author user-ctrl">
			      <div class="avatar">
			      	<div class="inner">
			        @if ($person->photo)
			          <img src="{{$person->photo}}">
			        @else			          
			            {{ render_initials( $person->name ? $person->name : $person->email   ) }}			          
			        @endif
			        </div>
			      </div>      
			    </div>	

			    <div class="name">
			    	<div class="fullname">{{$person->name}}</div>
			    	 @if($person->instagram)<span>{{'@'.$person->instagram}}</span>@endif
			    </div>

			</div>
			
			<div class="col-md-6">    
				@if ($peopleFollows->contains($person->id))
					<a data-action="unfollow" data-id="{{$person->id}}" class="follow-people-button">Unfollow</a>
				@else
					<a data-action="follow" data-id="{{$person->id}}" class="follow-people-button">Follow</a>
				@endif

			</div>

		</div>	

		<div class="row">

			<div class="col-md-12 profile">

				{{$person->profile}}

			</div>	


		</div>	

	</div>

</div>
