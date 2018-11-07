<a href="" class="set-link-reminder"  data-toggle="modal" data-target="#reminderModal"><i class="fa fa-clock"></i><p>Set a reminder on a link</p></a>

<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reminderModalLabel">Set Reminder In A Link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          {!! Form::open(['action' => 'LinksController@addreminder', 'method' => 'POST']) !!}
            <div class="row">
              <div class="col-md-12">
                {{Form::text('link', '', ['class' => 'form-control', 'placeholder' => 'Enter URL'])}}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                {{Form::text('day', '', ['class' => 'form-control', 'placeholder' => 'Number Of Day'])}}
              </div>
              <div class="col-md-6">
                {{Form::select('options', ['Day(s)', 'Week(s)', 'Month(s)'], 0, ['class' => 'form-control', 'placeholder' => 'Options'])}}
              </div>
            </div>
           {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="set-reminder-link btn btn-primary">Set Reminder</button>
      </div>
    </div>
  </div>
</div>
