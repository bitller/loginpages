
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('navigation-bar', require('./components/NavigationBar.vue'));
Vue.component('landing-page', require('./components/pages/LandingPage.vue'));
Vue.component('random-page', require('./components/pages/RandomPage.vue'));
Vue.component('favorites-page', require('./components/pages/FavoritesPage.vue'));
Vue.component('submit-page', require('./components/pages/SubmitPage.vue'));
Vue.component('favorites-page', require('./components/pages/FavoritesPage.vue'));
Vue.component('submited-pages-page', require('./components/pages/AdminCenter/SubmitedPagesPage.vue'));
Vue.component('users-page', require('./components/pages/AdminCenter/UsersPage.vue'));

const app = new Vue({
    el: 'body',

    data: function() {
        return {
            server: window.vueData
        }
    },

    ready: function() {
        this.$broadcast('sendingNavigationBarData', this.server);
    },

    events: {
        /**
         * Fired when landing page component is ready.
         */
        'loadingLandingPage': function() {
            this.$broadcast('sendingLandingPageData', this.server);
        },

        /**
         * Executed when submit page is ready.
         */
        'loadingSubmitPage': function() {
            this.$broadcast('sendingSubmitPageData', this.server);
        },

        /**
         * Executed when random page is accessed.
         */
        'loadingFavoritesPage': function() {
            this.$broadcast('sendingFavoritesPageData', this.server);
            this.$broadcast('setFavoritesAsActivePage');
        },

        'loadingRandomPage': function() {
            this.$broadcast('sendingRandomPageData', this.server);
            this.$broadcast('setRandomAsActivePage');
        },

        'close_opened_alert': function() {
            swal.close();
        },

        'success_alert': function(title, message) {
            swal({
                title: title,
                text: message,
                type: "success",
                // showCancelButton: true,
                // confirmButtonColor: "#DD6B55",
                confirmButtonText: "Close",
                // closeOnConfirm: false
            });
        },

        'loader': function() {
            swal({
                title: 'Loading...',
                type: 'info',
                closeOnConfirm: false,
                showConfirmButton: false,
                showCancelButton: false,
            });
        },

        'confirm': function(data, callback) {
            swal({
                title: data.title,
                text: data.message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: data.confirmButtonText,
                closeOnConfirm: false,
                showLoader: true,
            }, function() {
                callback();
            });
        },
    }
});
