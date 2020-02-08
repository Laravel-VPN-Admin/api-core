import Dashboard from './components/Pages/Dashboard';
import Servers   from './components/Pages/Servers';
import Groups    from './components/Pages/Groups';
import Users     from './components/Pages/Users';
import Logs      from './components/Pages/Logs';
import NotFound  from "./components/NotFound";

const routes = () => {
  return [
    {path: '/', name: 'dashboard', component: Dashboard},
    {path: '/servers', name: 'servers', component: Servers},
    {path: '/groups', name: 'groups', component: Groups},
    {path: '/users', name: 'users', component: Users},
    {path: '/logs', name: 'logs', component: Logs},
    {path: '*', name: '404', component: NotFound}
  ]
};

export default routes();
