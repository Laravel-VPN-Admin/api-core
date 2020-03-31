import Dashboard    from './components/Pages/Dashboard';
import Servers      from './components/Pages/Servers';
import Server       from './components/Pages/Server';
import ServerCreate from './components/Pages/ServerCreate';
import Groups       from './components/Pages/Groups';
import Group        from './components/Pages/Group';
import Users        from './components/Pages/Users';
import User         from './components/Pages/User';
import Logs         from './components/Pages/Logs';
import Settings     from './components/Pages/Settings';
import NotFound     from "./components/NotFound";
import Login        from './components/Login';

const routes = () => {
  return [
    {path: '/', redirect: {name: 'dashboard'}},
    {path: '/login', name: 'login', component: Login},
    {path: '/dashboard', name: 'dashboard', component: Dashboard},
    {path: '/servers', name: 'servers', component: Servers},
    {path: '/servers/create', name: 'servers.create', component: ServerCreate},
    {path: '/servers/:id', name: 'servers.edit', component: Server},
    {path: '/groups', name: 'groups', component: Groups},
    {path: '/groups/:id', name: 'groups.edit', component: Group},
    {path: '/users', name: 'users', component: Users},
    {path: '/users/:id', name: 'users.edit', component: User},
    {path: '/logs', name: 'logs', component: Logs},
    {path: '/settings', name: 'settings', component: Settings},
    {path: '*', name: '404', component: NotFound}
  ]
};

export default routes();
