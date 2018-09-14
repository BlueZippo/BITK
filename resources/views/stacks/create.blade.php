@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-8">
            
			<h1>Test PlatStack Post</h1>
            
            <hr />

            <form method="POST" action="/stacks">
                
                {{ csrf_field() }}
                
                <div class="form-group">
                    
                    <label for="title">Title</label>
                    
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                    
                </div>
                
                <div class="form-group">
                    
                    <label for="content">Content</label>
                    
                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                    
                </div>
                
                <button type="submit" class="btn btn-primary">Publish</button>
                
            </form>

		</div>
        
	</div>

@endsection