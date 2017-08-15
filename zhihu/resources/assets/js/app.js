/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue';
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);
Vue.component('example', require('./components/Example.vue'));
Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));
Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));
Vue.component('vote-follow-button', require('./components/VoteFollowButton.vue'));
Vue.component('send-message', require('./components/SendMessage.vue'));
Vue.component('comments', require('./components/Comments.vue'));

const app = new Vue({
    el: '#app'
});
