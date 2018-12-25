import React, { Component } from 'react';

export default class WhatsNew extends Component {

	constructor(props) 
	{
       super(props);
       this.state = {value: '', 
       				 items: ''
       				};
     }

	componentDidMount()
	{
    	console.log(this.props.params.id);
    	fetch("/whatsnew")
    	.then(response => {
      		this.setState({ items: response.data });
    	})
    	.catch(function (error) {
      		console.log(error);
    	})
  	}

    render() {
        return (
            <div className="whats-new">
            	<h2>What's New</h2>
              the quick brown
            </div>
        );
    }
}