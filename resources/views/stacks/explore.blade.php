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

<script src="{{ asset('js/plugins/chosen/chosen.jquery.min.js') }}"></script>

<link href="{{ asset('js/plugins/chosen/chosen.css') }}" rel="stylesheet">

<script>

    var display = $.totalStorage('display');

    if (display)
    {
        $('.stack-list').removeClass('tile');
        $('.stack-list').removeClass('compact');
        $('.stack-list').removeClass('list');

        $('.stack-list').addClass(display);
    }

    $(document).ready(function()
    {
         $('select.chosen').chosen();


         @if (Auth::check())

         $('.sort-button select.chosen').change(function()
         {
            location = '/stacks/' + $(this).val();
         });

         @else

         $('.sort-button select.chosen').change(function()
         {
            location = '/s/' + $(this).val();
         });

         @endif

    });


</script>
@endsection