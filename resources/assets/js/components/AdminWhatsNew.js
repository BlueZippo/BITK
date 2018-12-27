import React, { Component } from 'react';
import renderHTML from 'react-render-html';
import axios from 'axios';
import { Link } from 'react-router-dom';
import TableRow from './TableRow';


export default class AdminWhatsNew extends Component {

	constructor(props) 
	{
    super(props);
    this.state = {title: '', content: ''};
  }

	componentDidMount()
  {
    axios.get('/admin/whatsnew/list')
       .then(response => {
         this.setState({ items: response.data });
       })
       .catch(function (error) {
         console.log(error);
    })
  }

  tabRow()
  {

    
    if(this.state.items instanceof Array)
    {
      return this.state.items.map(function(object, i)
      {
        return <TableRow obj={object} key={i} />;
      })
    }
  }

    render() {
    

        return (
            <div className="admin-whats-new">
            	
              <div className="col-lg-10 col-lg-offset-1">
                
                <a href="/admin/add-whatsnew" className="btn btn-success float-right">Add</a>

                <h2 className="float-left"><i className="fas fa-gift"></i> What's New</h2>
                
                <br clear="all" />
                <hr />

                <div className="table-responsive">
                    <table className="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date Published</th>
                                <th>Author</th>
                                <th colSpan={2}>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                           {this.tabRow()}     
                        </tbody>

                    </table>
                </div>

                

              </div>




            </div>
        );
    }
}