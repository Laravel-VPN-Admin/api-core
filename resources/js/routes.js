import Dashboard    from './components/Pages/Dashboard';
import Servers      from './components/Pages/Servers';
import ServerCreate from './components/Pages/ServerCreate';
import ServerEdit   from './components/Pages/ServerEdit';
import Groups       from './components/Pages/Groups';
import GroupCreate  from './components/Pages/GroupCreate';
import GroupEdit    from './components/Pages/GroupEdit';
import Users        from './components/Pages/Users';
import UserCreate   from './components/Pages/UserCreate';
import UserEdit     from './components/Pages/UserEdit';
import Logs         from './components/Pages/Logs';
import Log          from './components/Pages/Log';
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
    {path: '/servers/:id', name: 'servers.edit', component: ServerEdit},
    {path: '/groups', name: 'groups', component: Groups},
    {path: '/groups/create', name: 'groups.create', component: GroupCreate},
    {path: '/groups/:id', name: 'groups.edit', component: GroupEdit},
    {path: '/users', name: 'users', component: Users},
    {path: '/users/create', name: 'users.create', component: UserCreate},
    {path: '/users/:id', name: 'users.edit', component: UserEdit},
    {path: '/logs', name: 'logs', component: Logs},
    {path: '/logs/:id', name: 'logs.edit', component: Log},
    {path: '/settings', name: 'settings', component: Settings},
    {path: '*', name: '404', component: NotFound}
  ]
};

export default routes();
