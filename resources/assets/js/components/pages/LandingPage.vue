<style>
    .newsletter {
        background-color: #F4645F;
        color: #ffffff;
        border-radius: 3px;
    }
</style>

<template>
    <div class="col-md-12">

        <!-- BEGIN Welcome back alert for logged in users -->
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-info">Welcome back, user. Since your last visit, <a href="/since-last-visit"><strong>14 new login pages</strong></a> has been added.</div>
        </div>
        <!-- END Welcome back alert for logged in users -->

        <newsletter></newsletter>

        <page v-for="page in pages.data" :page="page"></page>

        <ul v-show="showPager" class="pager">
            <li><a href="#">Previous</a></li>
            <li><a href="#">Next</a></li>
        </ul>
    </div>
</template>

<script>
    import Page from '../../components/pages/LandingPage/Page.vue';
    import Newsletter from '../../components/Newsletter.vue';

    export default {

        components: {
            'page': Page,
            'newsletter': Newsletter,
        },

        data: function() {
            return {
                serverData: '',
                pages: '',
            }
        },

        ready: function() {
            // Request landing page data from server
            this.$dispatch('loader');
            var vm = this;
            this.loadPages(function() {
                vm.$dispatch('close_opened_alert');
            });
        },

        methods: {
            loadPages: function(successCallback) {
                var vm = this;
                this.$http.get('/').then(function(success) {
                    vm.pages = success.data;
                    if (typeof successCallback !== 'undefined') {
                        successCallback();
                    }
                }, function(error) {
                    //
                });
            }
        },

        computed: {
            showPager: function() {
                if (this.pages.total > this.pages.per_page) {
                    return true;
                }
                return false;
            }
        },

        events: {
            /**
             * Get landing page data from server.
             */
            'sendingLandingPageData': function(data) {
                this.serverData = data;
            },

            /**
             * Load pages event.
             */
            'loadPages': function(callback) {
                if (typeof callback === 'undefined') {
                    this.loadPages();
                    return;
                }
                this.loadPages(callback);
            }
        }
    }
</script>
