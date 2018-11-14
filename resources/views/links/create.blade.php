<div class="add-link-form">

  @if (Auth::check())

  <form>  

    <div class="add-links-container">

        <div class="add-link">

          @include('links.create-step1')

          @include('links.create-step2')   

          <div class="row">               

            <div class="col-md-12 text-right">

              <a class="cancel-btn">Cancel</a> <a class="btn btn-primary submit-button">Save</a>

            </div>

          </div> 

        </div>

    </div>            

 </form> 

 @else

 Please <a href="/login">login</a> or <a href="/register">register</a> to add link

 @endif

</div>