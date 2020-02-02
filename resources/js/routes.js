import Welcome from './components/Welcome.vue'
import PaginatorGroups from "./components/PaginatorGroups";
import NotFound from "./components/NotFound";
import Login from "./components/Login";

// Only for tests, then I will refactor and do it beautifully
const routes = () => {
    return [
        {path: '/', name: 'welcome', component: Welcome},
        {path: '/paginator', component: PaginatorGroups},
        {path: '/signin', component: Login},
        {path: '*', component: NotFound}
    ]
}

export default routes()
