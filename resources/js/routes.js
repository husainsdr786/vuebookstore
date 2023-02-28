export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/book', component: require('./components/Book.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
