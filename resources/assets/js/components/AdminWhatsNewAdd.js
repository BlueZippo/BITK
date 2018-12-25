import React, { Component } from 'react';
import renderHTML from 'react-render-html';

export default class AdminWhatsNewAdd extends Component {

	constructor(props) 
	{
       super(props);

       this.state = {title:'', content: ''};
       
       this.handleChange = this.handleChange.bind(this);
       this.handleSubmit = this.handleSubmit.bind(this);

    }


    handleChange(e)
    {
    	var name = e.target.name;

    	switch (name)
    	{
    		case 'title':

    			this.state.title = e.target.value;

    		break;

    		case 'content':

    			this.state.content = e.target.value;

    		break;
    	}
    	
  	}

  	

    handleSubmit(event) 
    {
    	event.preventDefault();
    	const data = {
      		title: this.state.title,
      		content: this.state.content
    	}

    	let uri = '/admin/whatsnew/submit/';
    	axios.patch(uri, data).then((response) => 
    	{
    		console.log(this.props);
          	this.props.history.push('/admin/whatsnew');
    	});
  	}
	

    render() {
    
        return (
            <div className="whats-new-add">
            	<div className="row">

				    <div className="col-lg-12 margin-tb">

				        <div className="pull-left">

				            <h2><i className="fas fa-gift"></i> Add What's New</h2>

				        </div>

				        <div className="pull-right">

				            <a className="btn btn-primary" href="/admin/whatsnew"> Back</a>

				        </div>

				    </div>

				</div>



				<form onSubmit={this.handleSubmit}>

				    <div className="row">

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Title:</strong>

				                <input onChange={this.handleChange} type="text" name="title" className="form-control" placeholder="Enter a title..." />

				            </div>

				        </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Body:</strong>

				                <br/>

				                <textarea onChange={this.handleChange} name="content" className="form-control textarea" placeholder="Add content here..."></textarea>
				               

				            </div>

				        </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <button type="submit" className="btn btn-primary">Submit</button>

				        </div>

				    </div>

				</form>



            </div>
        );
    }
}