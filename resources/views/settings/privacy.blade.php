<div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab">
  <h5>PRIVACY</h5>

  <ul>
  	<li>{{Form::checkbox('allow_indexed_by_google', 1, $setting->allow_indexed_by_google)}} Allow My Profile and Content To Be Indexed By Google</li>
  	<li>{{Form::checkbox('allow_adult_content', 1, $setting->allow_adult_content)}} Allow Adult Content In Your Feed.<small>Learn More</small></li>
  	<li>Inbox Preferences</li>  	
	<li>Which registered users would you like to receive message from?<br />
		{{Form::radio('inbox_preference', 1, $setting->inbox_preference == 1 ? true : false)}} Allow Any Person On Platstack To Send Me Messages<br />
  		{{Form::radio('inbox_preference', 2, $setting->inbox_preference == 2 ? true : false)}} Allow Any Person On Platstack I Follow To Send Me Messages<br />
  		{{Form::radio('inbox_preference', 3, $setting->inbox_preference == 3 ? true : false)}} Allow No One To Send Me Messages
  	</li>  	
  	<li>Delete Or Deactivate Your Account</li>  	
  	<li>Deactivate Account</li>  	
  	<li>Delete Account</li>  	
  </ul>
</div>