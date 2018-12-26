// TableRow.js

import React, { Component } from 'react';

class DivList extends Component {
  render() {    

    return (

      <div className="whats-new-item">
        <h3><a href={"/whats-new-single/" + this.props.obj.id}>{this.props.obj.title}</a></h3>
        {this.props.obj.content}
      </div>        
    );
  }
}

export default DivList;