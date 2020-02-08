import Dashboard from './components/Pages/Dashboard';
import Servers   from './components/Pages/Servers';
import Server    from './components/Pages/Server';
import Groups    from './components/Pages/Groups';
import Group     from './components/Pages/Group';
import Users     from './components/Pages/Users';
import User      from './components/Pages/User';
import Logs      from './components/Pages/Logs';
import NotFound  from "./components/NotFound";

const routes = () => {
  return [
    {path: '/', redirect: {name: 'dashboard'}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard},
    {path: '/servers', name: 'servers', component: Servers},
    {path: '/servers/:id', name: 'servers.edit', component: Server},
    {path: '/groups', name: 'groups', component: Groups},
    {path: '/groups/:id', name: 'groups.edit', component: Group},
    {path: '/users', name: 'users', component: Users},
    {path: '/users/:id', name: 'users.edit', component: User},
    {path: '/logs', name: 'logs', component: Logs},
    {path: '*', name: '404', component: NotFound}
  ]
};

export default routes();
