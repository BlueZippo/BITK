<div class="add-link">

              
                <div class="form-group">

                    {{Form::label('link_url', 'Pasted Link:')}}
                    {{Form::text('link_url', '', ['class' => 'form-control', 'placeholder' => 'Enter the link here....'])}}

                    {{Form::hidden('link_category', 0)}}

                </div>

                <div class="row link-details-area">

                    <div class="col-md-5">

                        Link Image:

                        <div class="link-image solid" data-field="image">

                          <div class="image-container content"></div>

                          <a class="fa fa-edit"></a>
                          
                        </div>

                    </div>

                    <div class="col-md-7">

                        <div class="form-group">

                            {{Form::label('link_title', 'Link Title')}}
                            <div class="solid" data-field="link_title">

                              <div class="content" editablecontent="false">

                              </div>

                              <a class="fa fa-edit"></a>

                            </div> 

                        </div>

                        <div class="form-group">

                            {{Form::label('link_description', 'Link Description')}}
                            <div class="solid" data-field="link_description">

                              <div class="content" editablecontent="false">

                              </div>

                              <a class="fa fa-edit"></a>

                            </div> 

                        </div>


                    </div>

                </div> 

                <div class="row">               

                  <div class="col-md-12 text-right">


                    <a class="cancel-btn" onclick="$('.links-container').hide();">Cancel</a> <a class="btn btn-primary submit-button">Submit</a>


                  </div>  


                </div> 

            </div>