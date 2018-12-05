<div class="tab-pane fade" id="v-pills-email" role="tabpanel" aria-labelledby="v-pills-email-tab">
  <h5>COMMENTS & ACTIVITY</h5>

  <ul>
  	<li>{{Form::checkbox('activity_public_content', 1, $setting->activity_public_content)}} Activity on my public content</li>
  	<li>{{Form::checkbox('activity_comments_and_replies', 1, $setting->activity_comments_and_replies)}} Activity on my comments & replies</li>
  	<li>{{Form::checkbox('mentions', 1, $setting->mentions)}} Mentions</li>
  	<li>{{Form::checkbox('new_messages', 1, $setting->new_messages)}} New messages and direct message requests</li>
  	<li>{{Form::checkbox('timed_reminders', 1, $setting->timed_reminders)}} Timed Reminders</li>
  	<li>{{Form::checkbox('upvotes', 1, $setting->upvotes)}} Upvotes<small>We'll email you when another person upvotes your content.</small></li>
  	<li>{{Form::checkbox('new_followers', 1, $setting->new_followers)}} New Followers<small>We'll email you a new person starts following you</small></li>
  	<li><h6>Stacks I'm Following</h6><br />
  		{{Form::radio('stacks_following', 1, $setting->stacks_following == 1 ? true : false)}} All Stacks I'm Following<br />
  		{{Form::radio('stacks_following', 2, $setting->stacks_following == 2 ? true : false)}} Only My Favorite Stacks<br />
  		{{Form::radio('stacks_following', 3, $setting->stacks_following == 3 ? true : false)}} None
  	</li>
	<li><h6>People I'm Following</h6><br />
		{{Form::radio('people_following', 1, $setting->people_following == 1 ? true : false)}} All People I'm Following<br />
  		{{Form::radio('people_following', 2, $setting->people_following == 2 ? true : false)}} Only Those Who I've Allowed To Direct Message Me<br />
  		{{Form::radio('people_following', 3, $setting->people_following == 3 ? true : false)}} None
  	</li>  	
  </ul>
</div>