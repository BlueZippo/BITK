@extends ('layouts.master')

@section('content')


    @include('stacks.explore-nav')
   

    <div class="stack-list tile">

        @foreach($stacks as $stack)

            <div class="single-stack-wrapper">

                    @include('stacks.box')

            </div>


        @endforeach
        
        
    </div>   




<div class="modal fade" id="popupComments" tabindex="-1" role="dialog" aria-labelledby="popupComments" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="popupComments">Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
   

@endsection

@section('scripts')
<script>

    var display = $.totalStorage('display');

    if (display)
    {
        $('.stack-list').removeClass('tile');
        $('.stack-list').removeClass('compact');
        $('.stack-list').removeClass('list');

        $('.stack-list').addClass(display);
    }


</script>
@endsection