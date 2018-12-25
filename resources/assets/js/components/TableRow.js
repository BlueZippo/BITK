// TableRow.js

import React, { Component } from 'react';

class TableRow extends Component {
  render() {

    var Link = require('react-router').Link

    return (
        <tr>
          <td>
            {this.props.obj.title}
          </td>
          <td>
            {this.props.obj.date}
          </td>
          <td>
            {this.props.obj.author}
          </td>
          <td>
            <a href={"/admin/edit-whatsnew/" + this.props.obj.id} className="btn btn-primary">Edit</a>
          </td>
          <td>
          <form onSubmit={this.handleSubmit}>
           <input type="submit" value="Delete" className="btn btn-danger"/>
         </form>
          </td>
        </tr>
    );
  }
}

export default TableRow;