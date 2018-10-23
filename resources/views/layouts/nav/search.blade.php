<div class="search-wrapper">
	<form action="/stacks/search" method="POST" role="search">
	    {{ csrf_field() }}
        <div class="input-group">
        	<input type="text" class="form-control" name="search" placeholder="Search">        	
        </div>
        <a class="input-button"><i class="fa fa-search"></i></a>
	</form>
</div>
