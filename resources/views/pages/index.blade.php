@extends('layouts.master')

@section('style')

<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ asset('js/plugins/custom/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

@endsection


@section('content')

	<div class="dashboard">

		<div class="nav-wrapper">
			@include('pages.nav')

			{{--@include('pages.layout-control')--}}

		</div>

		@include('stacks.following')

		@include('people.following')

		@include('stacks.mystacks')

		@include('stacks.recommended')

		@include('pages.tags')

		@include('pages.parking')

        @include('links.create')

	</div>

@endsection

@section('scripts')

<script src="{{ asset('js/plugins/chosen/chosen.jquery.min.js') }}"></script>

<link href="{{ asset('js/plugins/chosen/chosen.css') }}" rel="stylesheet">

<script>



var STACKS = {!!$MyStacks!!};

$(document).ready(function()
{
    $('select[name=stack_id]').chosen();
});

$('input[name=link_url]').focusout(function()
    {
    $('.continue-button').addClass('disabled');

    $('.solid .content').html('Fetching link information, please wait...')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/get-meta-tags',
        data: $('.links-container input'),
        type: 'post',
        dataType: 'json',
        success: function(data)
        {
            if (data.title)
            {
                $('*[data-field="link_title"] .content').html(data.title)
            }

            if (data.description)
            {
                $('*[data-field="link_description"] .content').html(data.description);
            }

            if (data.image)
            {
                $('.image-container').html('<img src="'+data.image+'">');
            }

            $('input[name=link_description]').val(data.description);
            $('input[name=link_image]').val(data.image);
            $('input[name=link_title]').val(data.title);

            $('.continue-button').removeClass('disabled');
        }
    });
});

$('a.fa-edit').click(function()
{
    var par = $(this).parent();

    $('.content', par).each(function()
    {
        $(this).attr('contenteditable', true);

        if ($(this).html() == 'enter title...' || $(this).html() == 'enter description...')
        {
            $(this).html('');
        }

        $(par).removeClass('error');
        $(this).focus();
    });
});

$('.submit-button').click(function()
{
    var par = $('.add-link-form form').serialize();

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/store',
        data: par,
        type: 'post',
        dataType: 'json',
        success: function(data)
        {

        }

    })


    $('.add-link-form').hide();
});

$.widget( "custom.catcomplete", $.ui.autocomplete, 
{
  _create: function() {
    this._super();
    this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
  },
  _renderMenu: function( ul, items ) {
    var that = this,
      currentCategory = "";
    $.each( items, function( index, item ) {
        var li;
        
        li = that._renderItemData( ul, item );
        
    });
  },
  focus: function( event, ui )
  {
    $( ".stack-name" ).val( ui.item.label );
        return false;
  },
  select: function( event, ui )
  {
        $( ".stack-name" ).val( ui.item.label );
        $( "input[name=stack_id]" ).val( ui.item.value );

        return false;
   }
});

$('.stack-name').catcomplete(
{
    delay:0,
    source:STACKS
})

/*
$( ".stack-name" ).autocomplete({
    minLength: 0,
    source: STACKS,
    focus: function( event, ui )
    {
        $( ".stack-name" ).val( ui.item.label );
            return false;
    },
    select: function( event, ui )
    {
        $( ".stack-name" ).val( ui.item.label );
        $( "input[name=stack_id]" ).val( ui.item.value );

        return false;
    }
})
.autocomplete("instance")._renderMenu = function( ul, items ) {
    var that = this;
    $.each( items, function( index, item ) {
        console.log(item);
    });
  }
.autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
    .append( "<div>" + item.label +  "</div>" )
    .appendTo( ul );
};
*/

</script>

@endsection
