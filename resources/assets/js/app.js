
require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { Route, Link, BrowserRouter as Router } from 'react-router-dom';

import WhatsNew from './components/WhatsNew';
import WhatsNewSingle from './components/WhatsNewSingle';
import WhatsNewNotification from './components/WhatsNewNotification';
import AdminWhatsNew from './components/AdminWhatsNew';
import AdminWhatsNewAdd from './components/AdminWhatsNewAdd';
import AdminWhatsNewEdit from './components/AdminWhatsNewEdit';

render(
	<div>
		<WhatsNewNotification />
		<Router>
			<div>
				<Route path="/whats-new" component={WhatsNew} />
	      		<Route path="/whats-new-single/:id" component={WhatsNewSingle} />
	      		<Route path="/admin/whatsnew" component={AdminWhatsNew} />        
	      		<Route path="/admin/add-whatsnew" component={AdminWhatsNewAdd} />        
	      		<Route path={"/admin/edit-whatsnew/:id"} component={AdminWhatsNewEdit} />        
	      	</div>
    	</Router>
    </div>, 
    document.getElementById('example'));