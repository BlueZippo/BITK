import React, { Component } from 'react';
import axios from 'axios';
import DivList from './DivList';
import './whats-new.css'; 


export default class WhatsNewSingle extends Component {

	constructor(props) 
	{
    super(props);
    this.state = {data: ''};
  }

	  componentDidMount()
	  {    	
    	axios.get("/whatsnew/" + this.props.match.params.id + "/show")
    	.then(response => {
      		this.setState({  
            info: response.data.info
          });         
    	})
    	.catch(function (error) {
      		console.log(error);
    	});
  	}

    render() {

      const info = this.state.info;

      return (

            info ?

            <div className="whats-new-single">
              <h2><i className="fas fa-gift"></i> {info.title}</h2>              

              <div className="whats-new-article">
                {info.content}
              </div>
            </div>

           

            : null


        );
    }
}