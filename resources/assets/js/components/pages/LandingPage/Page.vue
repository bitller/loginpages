<style>
    .star {
        color: orange;
    }
    .max-width {
        width: 860px;
    }
    .image-shadow {
        box-shadow: 0 0 10px red;
    }
    .center-image {
        margin: 0 auto;
    }
    .margin-top {
        margin-top: 10px;
    }
    .margin-bottom {
        margin-bottom: 130px;
    }
</style>

<template>
    <div class="margin-bottom">
        <!-- BEGIN Page name -->
        <div class="col-md-12 text-center">
            <h3><a :href="page.url" target="_blank">{{ page.name }}</a></h3>
        </div>
        <!-- END Page name -->

        <img class="img-responsive center-image max-width image-shadow" :src="page.s3_url" />

        <div class="col-md-6 col-md-offset-3 text-center">
            <div class="row margin-top">
                <div class="col-md-8 col-md-offset-2">
                    <!-- BEGIN Add to favorites button -->
                    <div v-if="!favoritePage" @click="addToFavorites" class="btn btn-default btn-block btn-lg">
                        <span class="glyphicon glyphicon-star"></span>&nbsp;Add to Favorites
                    </div>
                    <!-- END Add to favorites button -->

                    <!-- BEGIN Remove from favorites button -->
                    <div v-if="favoritePage" @click="removeFromFavorites" class="btn btn-default btn-block btn-lg">
                        <span class="glyphicon glyphicon-star star"></span>&nbsp;Remove from Favorites
                    </div>
                    <!-- END Remove from favorites button -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['page', 'type'],

        ready: function() {
            return {
                removeFromFavoritesConfirmation: {
                    title: 'Are you sure?',
                    message: this.page.name + ' will no longer be in your favorite pages section.',
                },
            }
        },

        methods: {

            addToFavorites: function() {
                var vm = this;
                var page = {
                    page_id: this.page.id,
                };
                this.$http.post('/favorites/add', page).then(function(success) {
                    vm.$dispatch('loadPages', function() {
                        //
                    });
                }, function(error) {
                    //
                });
            },

            removeFromFavorites: function() {
                if (this.favoritePagesSection) {
                    this.removeFromFavoritesFavoriteSection();
                    return;
                }

                this.removeFromFavoritesLandingSection();
            },

            removeFromFavoritesLandingSection() {
                var vm = this;
                this.$dispatch('confirm', this.removeFromFavoritesConfirmation, function() {
                    // Make request to the server to remove page from favorites
                    vm.removeFromFavoritesRequest(function(response) {
                        // Reload pages
                        vm.$dispatch('loadPages', function() {
                            // Show alert
                            vm.$dispatch('success_alert', response.data.title, response.data.message);
                        });
                    });
                });
            },

            removeFromFavoritesFavoriteSection() {
                var vm = this;
                var details = {
                    title: 'Are you sure?',
                    message: this.page.name + ' will no longer be in your favorite pages section.'
                };
                // Ask user for confirmation
                this.$dispatch('confirm', details, function() {
                    // Make request that remove page from favorites
                    vm.removeFromFavoritesRequest(function(response) {
                        // Make request to reload favorite pages
                        vm.$dispatch('loadFavoritePages', function() {
                            // Show success alert with appropiate message
                            vm.$dispatch('success_alert', response.data.title, response.data.message);
                        });
                    });
                });
            },

            /**
             * Just make post request to remove page from favorites and execute given success callback.
             */
            removeFromFavoritesRequest: function(successCallback) {
                var vm = this;
                var data = {
                    page_id: this.page.id,
                };

                this.$http.post('/favorites/remove', data).then(function(success) {
                    successCallback(success);
                }, function(error) {
                    //
                });
            }
        },

        computed: {
            favoritePage: function() {
                // Show 'remove from favorites' when we are on favorites page
                if (this.favoritePagesSection) {
                    return true;
                }

                // todo check also if a page is favorite when we are on landing page
                if (this.page.page_id) {
                    return true;
                }
                return false;
            },

            favoritePagesSection: function() {
                if (this.type === 'favorite') {
                    return true;
                }
                return false;
            },

            landingPageSection: function() {
                if (this.type === 'landing') {
                    return true;
                }
                return false;
            },
        }
    }
</script>
