
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

Vue.component('video-upload', require('./components/VideoUpload.vue'));
Vue.component('subscribe-button', require('./components/SubscribeButton.vue'));
Vue.component('video-comments', require('./components/VideoComments.vue'));
Vue.component('video-player', require('./components/VideoPlayer.vue'));
Vue.component('video-voting', require('./components/VideoVoting.vue'));

const app = new Vue({
    el: '#app',
    data: window.codetube
});
