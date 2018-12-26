import React, { Component } from 'react';
import axios from 'axios';
import DivList from './DivList';
import './whats-new.css'; 

export default class WhatsNew extends Component {

	constructor(props) 
	{
    super(props);
    this.state = {items: '', visible: true};

    this.toggleBox = this.toggleBox.bind(this);
  }

	componentDidMount()
	{    	
    	axios.get("/whatsnew")
    	.then(response => {
      		this.setState({ items: response.data });
    	})
    	.catch(function (error) {
      		console.log(error);
    	})
  	}


    divList()
    {      
      if(this.state.items instanceof Array)
      {
        return this.state.items.map(function(object, i)
        {
          return <DivList obj={object} key={i} />;
        })
      }
    }    

    toggleBox()
    {
      this.setState({visible:false});
    }

    render() {
        return (

            this.state.visible ?

            <div className="whats-new">
              <a onClick={this.toggleBox} className="fas fa-times"></a>
            	<h2><i className="fas fa-gift"></i> What's New</h2>
              <div className="whats-new-list">
                {this.divList()}
              </div>              
            </div>

            : null
        );
    }
}