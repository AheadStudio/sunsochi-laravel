
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var VueCookie = require('vue-cookie');
// Tell Vue to use the plugin
Vue.use(VueCookie);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import ratingComponent from "./components/RatingComponent.vue";

const appBlog = new Vue({
    el: "#sunsochi-app-blog",
    components: {
        "rating-component" : ratingComponent
    },
    mounted: function() {
        var self = this;
        SUNSOCHI.fixedBlock.sticky();
    },
});
