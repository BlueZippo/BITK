import React, { Component } from 'react';
import axios from 'axios';
import DivList from './DivList';
import './whats-new.css'; 


export default class WhatsNewNotification extends Component {

	 constructor(props)
   {
    super(props);
    this.state =
    {
      totalNotification: 0
    }

    this.handleClick = this.handleClick.bind(this);
   }

	  componentDidMount()
	  {    	
    	axios.get("/whatsnew/notification")
      .then(response => {
          this.setState({ totalNotification: response.data });
      })
      .catch(function (error) {
          console.log(error);
      })
  	}

    handleClick()
    {
      window.location = '/whats-new';
    }

    render() {

      return (

        this.state.totalNotification > 0 ?

        <div onClick={this.handleClick} className="whats-new-notification">
          <i className="fas fa-gift"></i> {this.state.totalNotification}
        </div>

        : null

        );
    }
}