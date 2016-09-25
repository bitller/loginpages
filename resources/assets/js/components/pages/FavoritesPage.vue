<template>
    <div class="col-md-12">

        <!-- BEGIN No favorite pages alert -->
        <div v-if="!existsFavoritePages" class="alert alert-info">
            You don't have any page marked as your favorite. Use the "Add to Favorites" button to save here the pages you like most.
        </div>
        <!-- END No favorite pages alert -->

        <page v-for="page in favoritePages.data" :page="page" type="favorite"></page>

        <!-- BEGIN Pager -->
        <ul v-show="showPager" class="pager">
            <li><a href="#">Previous</a></li>
            <li><a href="#">Next</a></li>
        </ul>
        <!-- END Pager -->
    </div>
</template>

<script>
    import Page from '../../components/pages/LandingPage/Page.vue';

    export default {

        components: {
            'page': Page,
        },

        data: function() {
            return {
                favoritePages: '',
            }
        },

        ready: function() {
            // Show loader
            this.$dispatch('loader');

            this.$dispatch('loadingFavoritesPage');

            // Request data from server
            var vm = this;
            this.loadFavoritePages(function() {
                vm.$dispatch('close_opened_alert');
            });
        },

        methods: {
            loadFavoritePages: function(successCallback) {
                var vm = this;
                this.$http.get('/favorites').then(function(success) {
                    vm.favoritePages = success.data;
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
                if (this.favoritePages.total > this.favoritePages.per_page) {
                    return true;
                }
                return false;
            },

            existsFavoritePages: function() {
                if (this.favoritePages.total > 0) {
                    return true;
                }
                return false;
            },
        },

        events: {
            'loadFavoritePages': function(callback) {
                console.log('also called');
                if (typeof callback === 'undefined') {
                    this.loadFavoritePages();
                    return;
                }
                this.loadFavoritePages(callback);
            },
        },

    }
</script>
