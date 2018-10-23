<div class="search-wrapper">
	<form action="/stacks/search" method="POST" role="search">
	    {{ csrf_field() }}
	    <div class="row">
	        <div class="input-group col-md-12">
	        	<a class="search-button"><i class="fa fa-search"></i></a>
	            <input type="text" required class="form-control" name="search" placeholder="Search">
	        </div>
	    </div>
	</form>
</div>