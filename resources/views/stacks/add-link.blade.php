<div class="well links-container">

    <div class="add-link">

        <h3>Add Link</h3>


        <div class="form-group">

            {{Form::label('link_url', 'Pasted Link')}}
            {{Form::text('link_url', '', ['class' => 'form-control', 'placeholder' => 'Enter the link here....'])}}

        </div>

        <div class="row">

            <div class="col-md-4">

                Link Image:

                <span class="link-image"><img src="/images/no-available-image.png"></span>

            </div>

            <div class="col-md-8">

                <div class="form-group">

                    {{Form::label('link_title', 'Link Title')}}
                    {{Form::text('link_title', '', ['class' => 'form-control', 'placeholder' => 'Enter the link title here....'])}}

                </div>

                <div class="form-group">

                    {{Form::label('link_description', 'Link Description')}}
                    {{Form::textarea('link_description', '', ['class' => 'form-control', 'placeholder' => 'Enter the link description here....'])}}

                </div>


            </div>

        </div>


        <a class="btn btn-primary add-link-button">Add Link</a>

        

    </div>

</div>            