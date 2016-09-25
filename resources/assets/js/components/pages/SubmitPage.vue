<style>
    .submit-page-well {
        background-color: #ffffff;
        border-radius: 3px;
        padding: 25px 40px;
        border-bottom: 2px solid #e7e7e7;
    }
</style>
<template>

    <!-- BEGIN User not logged in -->
    <div v-if="!userIsLoggedIn">
        <div class="alert alert-info">
            Connect with one of the following providers in order to submit a page.
        </div>

        <div @click="showConnectModal" class="btn btn-primary">Connect</div>
    </div>
    <!-- END User not logged in -->

    <!-- BEGIN User logged in -->
    <div v-if="userIsLoggedIn">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-info">Help us improve LoginPages.xyz by submitting awesome login pages. Thank you!</div>

                <!-- BEGIN Submit page well -->
                <div class="submit-page-well">

                    <div v-show="hasError" class="alert alert-danger">{{ hasError }}</div>

                    <!-- BEGIN Login page name -->
                    <div :class="{ 'has-error': pageNameHasError }" class="form-group">
                        <label>Login page name</label>
                        <input v-model="page.name" @keyup.enter="submitPage" type="text" placeholder="Bitller" class="form-control custom-input-lg custom-input-with-border" />
                        <span v-show="pageNameHasError" class="text-danger">{{ pageNameHasError }}</span>
                    </div>
                    <!-- END Login page name -->

                    <!-- BEGIN Login page url -->
                    <div :class="{ 'has-error': pageUrlHasError }" class="form-group">
                        <label>Login page url</label>
                        <input v-model="page.url" @keyup.enter="submitPage" type="text" placeholder="http://bitller.com" class="form-control custom-input-lg custom-input-with-border" />
                        <span v-show="pageUrlHasError" class="text-danger">{{ pageUrlHasError }}</span>
                    </div>
                    <!-- END Login page url -->

                    <div @click="submitPage" class="btn btn-block btn-lg-custom btn-blue">Submit page</div>

                </div>
                <!-- END Submit page well -->

            </div>
        </div>
        <connect-modal></connect-modal>
    </div>
    <!-- END User logged in -->

</template>

<script>
    import ConnectModal from '../../components/modals/ConnectModal.vue';

    export default {

        components: {
            'connect-modal': ConnectModal,
        },

        data: function() {
            return {
                serverData: '',
                page: {
                    name: '',
                    url: '',
                },
                errors: {
                    pageName: '',
                    pageUrl: '',
                },
                error: '',
            }
        },

        ready: function() {
            // Request submit page data from server
            this.$dispatch('loadingSubmitPage');
        },

        methods: {
            showConnectModal: function() {
                this.$broadcast('showConnectModal');
            },

            submitPage: function() {
                this.emptyErrors();
                var data = {
                    page_name: this.page.name,
                    page_url: this.page.url,
                };

                var vm = this;

                this.$http.post('/submit', data).then(function(success) {
                    vm.$dispatch('success_alert', success.data.title, success.data.message);
                    vm.emptyInputs();
                }, function(error) {
                    if (error.data.page_name) {
                        vm.errors.pageName = error.data.page_name;
                    }
                    if (error.data.page_url) {
                        vm.errors.pageUrl = error.data.page_url;
                    }

                    if (vm.pageNameHasError || vm.pageUrlHasError) {
                        return;
                    }
                    vm.error = 'Ooops. An error occurred. Refresh the page and try again.';
                });
            },

            emptyErrors: function() {
                this.errors.pageName = this.errors.pageUrl = this.error = '';
            },

            emptyInputs: function() {
                this.page.name = this.page.url = '';
            },

        },

        computed: {
            userIsLoggedIn: function() {
                if (this.serverData.loggedIn) {
                    return true;
                }
                return false;
            },

            pageNameHasError: function() {
                if (this.errors.pageName) {
                    return this.errors.pageName;
                }
                return false;
            },

            pageUrlHasError: function() {
                if (this.errors.pageUrl) {
                    return this.errors.pageUrl;
                }
                return false;
            },

            hasError: function() {
                if (this.error) {
                    return this.error;
                }
                return false;
            },
        },

        events: {
            /**
             * Get submit page data from server.
             */
            'sendingSubmitPageData': function(data) {
                this.serverData = data;
            },
        }
    }
</script>
