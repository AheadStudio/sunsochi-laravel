
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VueCookie = require('vue-cookie');
// Tell Vue to use the plugin
window.Vue.use(window.VueCookie);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*import ratingComponent from "./components/RatingComponent.vue";
import paginationComponent from "./components/PaginationComponent.vue";


const appBlog = new Vue({
    el: "#sunsochi-app-blog",
    components: {
        "rating-component" : ratingComponent,
        "pagination-component" : paginationComponent,
    },
    mounted: function() {
        var self = this;

        self.$root.$on("nextPage", function(params) {
            self.loadNextPage(params);
        });

        self.$nextTick(function () {
            SUNSOCHI.fixedBlock.sticky();
            SUNSOCHI.autocomplete.init();
        });
    },
    methods: {
        loadNextPage: function(params) {
            var self = this,
                $linkAddress = $(params.link);

            if ($linkAddress.hasClass("loading")) {
                return false;
            } else {
                $linkAddress.addClass("loading");
            }

            (function(href, $container, $link, selector) {
                axios.get(params.page)
                    .then(function(data) {
                        var $data = $('<div />').append(data),
                            $items = $data.find(selector),
                            $preloader = $data.find(".load-more"),
                            $linkParent = $link.parent();

                        $items.addClass("load-events-item");
                        $container.append($items);
                        $link.remove();

                        if($preloader && $preloader.length) {
                            $linkParent.append($preloader);
                        }

                        setTimeout(function() {
                            $container.find(".load-events-item").removeClass("load-events-item");
                            $linkAddress.removeClass("loading");
                            //$linkAddress.prop("disabled", false);
                        }, 100);

                    });
            })(params.page, $(params.container), $(params.link),  $(params.item));
        }
    }
});
*/
