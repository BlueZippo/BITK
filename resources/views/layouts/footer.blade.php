    <footer class="footer">
      <div class="container">
        <span class="copyright">Platstack {{date("Y")}}</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

    <script src="{{ asset('js/jquery-confirm.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap-dialog.js') }}"></script>

    <script src="{{ asset('js/plugins/custom/jquery-ui.js') }}"></script>

    <script src="{{ asset('js/jquery.matchHeight-min.js') }}"></script>

    <script src="{{ asset('js/jquery.total-storage.min.js') }}"></script>

    <script src="{{ asset('js/dragdrop.js') }}"></script>

    <script src="{{ asset('js/script.js') }}"></script>

    <script src="{{ asset('js/upload-image.js') }}"></script>



    @if (Auth::check())
    @include('pages.add-link-scripts')
    @endif

    <script>
        new dragdrop.start((dom, api) => {
            dom.addEventListener('drop', (event) => {
                var drop = api.orders;

                var dashboard = [];

                for(i=1; i<= drop.length; i++)
                {
                    var id = 'dragdrop-target-' + i;

                    var c = $('#' + id + ' > div');

                    dashboard.push($(c).data('id'));
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax(
                {
                    url: '/user/dashboard',
                    data: {'dashboard': dashboard},
                    type:'post',
                    dataType:'json',
                    success: function(data)
                    {

                    }
                });

            })
        });
    </script>


    
