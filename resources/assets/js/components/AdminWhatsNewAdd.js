import React, { Component } from 'react';
import DatePicker from "react-datepicker";
import renderHTML from 'react-render-html';
import "react-datepicker/dist/react-datepicker.css";
import MyEditor from './MyEditor';

import moment from 'moment';
 

export default class AdminWhatsNewAdd extends Component {

	constructor(props) 
	{
       super(props);

       this.state = {title:'', 
              content: '', 
              id:0, 
              published_date: new Date(), 
              startDate: new Date(),
              subtitle:'', 
              type:'whatsnew',
              excerpt: ''};
       
       this.handleChange = this.handleChange.bind(this);
       this.handleSubmit = this.handleSubmit.bind(this);
       this.handleChangeDate = this.handleChangeDate.bind(this);
       this.updateContent = this.updateContent.bind(this);

    }

    updateContent(data)
    {
      this.setState({content: data});
    }

    handleChangeDate(date) 
    {
      this.setState({
          published_date: date
      });
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

    	let uri = '/admin/whatsnew/submit/';
    	axios.patch(uri, data).then((response) => 
    	{
    		console.log(this.props);
          	this.props.history.push('/admin/whatsnew');
    	})
      .catch(function (error) 
      {
        console.log(error);
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

                        <strong>Date:</strong>

                        <DatePicker className="form-control" selected={moment(this.state.published_date)}  onSelect={this.handleChangeDate} />

                    </div>

                </div>

              <div className="col-xs-12 col-sm-12 col-md-12">

                    <div className="form-group">

                        <strong>Type:</strong>

                        <select name="type" className="form-control" onChange={this.handleChange}>   
                          <option value="whatsnew">What's New</option>
                          <option value="news">News</option>
                        </select> 

                    </div>

                </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Title:</strong>

				                <input onChange={this.handleChange} type="text" name="title" className="form-control" placeholder="Enter a title..." />

				            </div>

				        </div>

                <div className="col-xs-12 col-sm-12 col-md-12">

                    <div className="form-group">

                        <strong>Subtitle:</strong>

                        <input type="text" onChange={this.handleChange} name="subtitle" className="form-control" />

                    </div>

                </div>

				        <div className="col-xs-12 col-sm-12 col-md-12">

				            <div className="form-group">

				                <strong>Body:</strong>

				                <br/>

				                <MyEditor UpdateContent={this.updateContent} />
				               

				            </div>

				        </div>

                <div className="col-xs-12 col-sm-12 col-md-12">

                    <div className="form-group">

                        <strong>Excerpt:</strong>

                        <br/>

                        <textarea onChange={this.handleChange} className="form-control textarea" name="excerpt"></textarea>
                       

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