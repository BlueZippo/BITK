@if(Request::path() == 'stacks/create')

	<div class="stack-control">

		<div class="float-left stack-ctrl-item back">
	        <i class="fas fa-arrow-left"></i>
	        <span>Back</span>
	    </div>

		<div class="float-left stack-ctrl-item switch-box">
			<div class="switch public" >
				<span>
					<i class="fas fa-eye-slash"></i> Private
				</span>
			</div>
	    </div>

	    <div class="float-left stack-ctrl-item save">
	        <span>Save Stack</span>
	        <i class="fas fa-save"></i>
	    </div>

	</div>
    

@endif