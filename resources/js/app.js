require('./bootstrap');

window.Vue = require('vue');

// Configs
import store from "./store";
import apollo from './apollo';

// Plugins
import Vue from 'vue';
import VueApollo from 'vue-apollo';
import VueRouter from 'vue-router';
import VueCookies from 'vue-cookies';
import {InertiaApp} from '@inertiajs/inertia-vue'

Vue.config.productionTip = false;

// Basic uses
Vue.use(VueRouter);
Vue.use(VueCookies);
Vue.use(VueApollo);
Vue.use(InertiaApp);

// Localization
Vue.filter('trans', (...args) => {
    return typeof window.Lang !== 'undefined' ? window.Lang.get(...args) : '';
});

// Plural support in localization
Vue.filter('trans_choice', (...args) => {
    return typeof window.Lang !== 'undefined' ? window.Lang.choice(...args) : '';
});

Vue.prototype.trans = (key, replacements, locale) => {
    return typeof window.Lang !== 'undefined' ? window.Lang.get(key, replacements, locale) : '';
};

const apolloProvider = new VueApollo({
    defaultClient: apollo,
});

const appDiv = document.getElementById('app');

export const app = new Vue({
    store,
    apolloProvider,
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(appDiv.dataset.page),
                resolveComponent: (name) => require(`./components/${name}`).default,
            }
        })
}).$mount(appDiv);
