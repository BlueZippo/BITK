import React, { Component } from 'react';
import renderHTML from 'react-render-html';
import MyEditor from './MyEditor';

class AdminWhatsNewEdit extends Component {

	constructor(props) 
	{
       super(props);

       this.state = {title:'', 
       				content: '', 
       				id:0, 
       				published_date: '', 
       				subtitle:'', 
       				type: 'whatsnew',
       				excerpt: ''};
       
       this.handleChange = this.handleChange.bind(this);
       this.handleSubmit = this.handleSubmit.bind(this);

    }

    
    componentDidMount()
    {
    	axios.get("/admin/whatsnew/" + this.props.match.params.id + "/edit")
    	.then(response => {
      		this.setState({ title: response.data.title, 
      						content: response.data.content, 
      						excerpt: response.data.excerpt,
      						published_date: response.data.published_date,
      						subtitle: response.data.subtitle,
      						type: response.data.type,
      						id:response.data.id });
    	})    	
    	.catch(function (error) {
      		console.log(error);
    	})
  	}
  	


    handleChange(e)
    {
    	var name = e.target.name;

    	switch (name)
    	{
    		case 'title':

    			this.setState({
      				title: e.target.value
    			})

    		break;

    		case 'published_date':

    			this.setState({
      				published_date: e.target.value
    			})

    		break;

    		case 'subtitle':

    			this.setState({
      				subtitle: e.target.value
    			})

    		break;

    		case 'excerpt':

    			this.setState({
      				excerpt: e.target.value
    			})

    		break;

    		case 'content':

    			this.setState({
      				content: e.target.value
    			})

    		break;

    		case 'type':

	          this.setState({
	              type: e.target.value
	          })

	        break;
    	}
    	
  	}

  	

    handleSubmit(event) 
    {
    	event.preventDefault();
    	
    	const data = {
      		title: this.state.title,
      		content: this.state.content,
      		excerpt: this.state.excerpt,
      		published_date: this.state.published_date,
      		subtitle: this.state.subtitle,
      		type: this.state.type
    	}

    	let uri = '/admin/whatsnew/'+ this.state.id + '/update/';
    	
    	axios.patch(uri, data).then((response) => 
    	{
    	  	this.props.history.push('/admin/whatsnew');
    	});
  	}
	

    render() {

    	return (
            <div className="whats-new-add">
            	<div className="row">

				    <div className="col-lg-12 margin-tb">

				        <div className="pull-left">

				            <h2><i className="fas fa-gift"></i> Edit What's New</h2>

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

				                <strong>Date:</strong>

				               	<input onChange={this.handleChange} type="text" name="published_date" className="form-control" value={this.state.published_date} />

				            </div>

				        </div>

				    	<div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Type:</strong>

				               	<select name="type" className="form-control"> 	
				               		<option value="whatsnew">What's New</option>
				               		<option value="news">News</option>
				                </select>	

				            </div>

				        </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Title:</strong>

				                <input type="hidden" name="id" value={this.state.id} />

				                <input onChange={this.handleChange} type="text" name="title" className="form-control" value={this.state.title} placeholder="Enter a title..." />

				            </div>

				        </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Subtitle:</strong>

				               	<input type="text" onChange={this.handleChange} name="subtitle" className="form-control" value={this.state.subtitle} />

				            </div>

				        </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Body:</strong>

				                <br/>

				                <textarea className="form-control textarea" onChange={this.handleChange} name="content" value={this.state.content}></textarea>

				                
				               

				            </div>

				        </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Excerpt:</strong>

				                <br/>

				                <textarea onChange={this.handleChange} className="form-control textarea" name="excerpt" value={this.state.excerpt}></textarea>
				               

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

export default AdminWhatsNewEdit