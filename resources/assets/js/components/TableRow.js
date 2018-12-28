// TableRow.js
import React, { Component } from 'react';
import axios from 'axios';

class TableRow extends Component {

  constructor(props)
  {
    super(props);

    this.state = 
    {
      id: props.obj.id,
      isVisible: true
    }

    this.handleDelete = this.handleDelete.bind(this);
  }

  handleDelete()
  {
    const data = {
          id: this.state.id,       
      }

    if (confirm("Are you sure you want to delete this?"))
    {
      axios.patch("/admin/whatsnew/delete", data).then((response) => {this.setState({isVisible:false}) });
    }  
  }


  render() {
    
    return (

      this.state.isVisible ? 

        <tr>
          <td>
            {this.props.obj.title}
          </td>
          <td>
            {this.props.obj.date}
          </td>
          <td>
            {this.props.obj.type}
          </td>
          <td>
            {this.props.obj.author}
          </td>
          <td>
            <a href={"/admin/edit-whatsnew/" + this.props.obj.id} className="btn btn-primary">Edit</a>
          </td>
          <td>
            
              <input onClick={this.handleDelete} type="submit" value="Delete" className="btn btn-danger"/>
            
          </td>
        </tr>

        : null
    );
  }
}

export default TableRow;