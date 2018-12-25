
require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { Route, Link, BrowserRouter as Router } from 'react-router-dom';

import WhatsNew from './components/WhatsNew';
import AdminWhatsNew from './components/AdminWhatsNew';
import AdminWhatsNewAdd from './components/AdminWhatsNewAdd';
import AdminWhatsNewEdit from './components/AdminWhatsNewEdit';

render(
	<Router>
		<div>
      		<Route path="/whats-new" component={WhatsNew} />
      		<Route path="/admin/whatsnew" component={AdminWhatsNew} />        
      		<Route path="/admin/add-whatsnew" component={AdminWhatsNewAdd} />        
      		<Route path={"/admin/edit-whatsnew/:id"} component={AdminWhatsNewEdit} />        
      	</div>
    </Router>, 
    document.getElementById('example'));