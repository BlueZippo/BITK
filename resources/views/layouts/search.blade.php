<div class="search-wrapper">
	<form action="/stacks/search" method="POST" role="search">
	    {{ csrf_field() }}
	    <div class="row">
	        <div class="input-group col-md-12">
	            <input type="text" class="form-control" name="search" placeholder="Search stacks"> <span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span></button>
	            </span>
	        </div>
	    </div>
	</form>
</div>