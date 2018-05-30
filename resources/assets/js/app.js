
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('existing-teams', require('./components/ExistingTeams.vue'));
Vue.component('team-registration', require('./components/TeamRegistrationForm.vue'));
Vue.component('team-progress', require('./components/TeamProgress.vue'));
Vue.component('team-progress-container', require('./components/TeamProgressContainer.vue'));

new Vue({
    el: '#teams'
});

new Vue({
    el: '#progress'
});
