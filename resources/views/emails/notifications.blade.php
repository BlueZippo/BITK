<div class="modal fade" id="notifications" tabindex="-1" role="dialog" aria-labelledby="notificationsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationsModalLabel">Messages & Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @foreach($notifications as $notification)
          <div>
         
            <a href="/people/{{$notification->person_id}}/stacks">{{$notification->person->name}}</a> is 
            
            @if ($notification->action == 'follow') following @endif 

            @if ($notification->action == 'vote') upvote into @endif 
            
            @if ($notification->type == 'stack')
            your <a href="/stacks/{{$notification->item_id}}/dashboard">{{$notification->stack->title}}</a> stack
            @endif

            @if ($notification->type == 'people')you @endif            

          </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>