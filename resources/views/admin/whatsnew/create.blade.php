<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Add What's New</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-primary" href="/admin/whatsnew"> Back</a>

        </div>

    </div>

</div>


@if (count($errors) > 0)

    <div class="alert alert-danger">

        <strong>Whoops!</strong> There were some problems with your input.<br><br>

        <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

        </ul>

    </div>

@endif


<form method="post">

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Title:</strong>

                {!! Form::text('title', null, array('placeholder' => 'title','class' => 'form-control')) !!}

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">

                <strong>Body:</strong>

                <br/>

                {!! Form::textarea('content', null, array('placeholder' => 'Content','class' => 'form-control')) !!}
               

            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </div>

</form>


