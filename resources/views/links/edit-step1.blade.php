<div class="step1">

              
                <div class="form-group">

                    {{Form::label('link_url', 'Step 1: Paste Link Here:')}}
                    {{Form::text('link_url', $link->link, ['class' => 'form-control', 'placeholder' => 'Enter the link here....'])}}

                    {{Form::hidden('link_image', $link->image)}}
                    {{Form::hidden('link_title', $link->title)}}
                    {{Form::hidden('link_description', $link->description)}}
                    {{Form::hidden('id', $link->id)}}
                    

                </div>

                <div class="row link-details-area">

                    <div class="col-md-5">

                        {{Form::label('link-image', 'Link Image:')}}

                        <div class="link-image solid" data-field="image">

                          <div class="image-container content"><img src="{{$link->image}}"></div>

                          <a class="fa fa-edit"></a>
                          
                        </div>

                    </div>

                    <div class="col-md-7">

                        <div class="form-group">

                            {{Form::label('link_title', 'Link Title:')}}
                            <div class="solid" data-field="link_title">

                              <div class="content" editablecontent="false">{{$link->title}}</div>

                              <a class="fa fa-edit"></a>

                            </div> 

                        </div>

                        <div class="form-group">

                            {{Form::label('link_description', 'Link Description:')}}
                            <div class="solid" data-field="link_description">

                              <div class="content" editablecontent="false">{{$link->description}}</div>

                              <a class="fa fa-edit"></a>

                            </div> 

                        </div>


                    </div>

                </div>

                </div>