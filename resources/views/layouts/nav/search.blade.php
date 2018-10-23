<div class="search-wrapper">
	<form action="/stacks/search" method="POST" role="search">
	    {{ csrf_field() }}
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search">
        </div>
	</form>
</div>
