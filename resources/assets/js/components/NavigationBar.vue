<template>
    <!-- BEGIN Navbar static top -->
    <nav class="navbar navbar-default navbar-static-top">

        <!-- BEGIN Container fluid -->
        <div class="container-fluid">

            <!-- BEGIN Container -->
            <div class="container">
                <div class="col-md-12">

                    <!-- BEGIN Navbar logo -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/">LoginPages.xyz</a>
                    </div>
                    <!-- END Navbar logo -->

                    <!-- BEGIN Navbar left menus -->
                    <ul class="nav navbar-nav">
                        <li :class="{ 'active': randomIsTheActivePage }"><a href="/random">Random</a></li>
                        <li :class="{ 'active': favoritesIsTheActivePage }"><a href="/favorites">Favorites</a></li>
                    </ul>
                    <!-- END Navbar left menus -->

                    <!-- BEGIN Navbar right menus -->
                    <ul class="nav navbar-nav navbar-right">

                        <li v-if="!userIsLoggedIn"><a @click="showConnectModal" href="#">Connect</a></li>
                        <!-- BEGIN User email and dropdown -->
                        <li v-if="userIsLoggedIn" class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                {{ serverData.user.email }}&nbsp;<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li v-if="userIsAdmin"><a href="/admin-center/submited-pages"><span class="glyphicon glyphicon-th"></span>&nbsp;Submited pages</a></li>
                                <li v-if="userIsAdmin"><a @click="showUploadPageModal" href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp;Upload page</a></li>
                                <li v-if="userIsAdmin" class="divider"></li>
                                <li v-if="userIsAdmin"><a href="/admin-center/users"><span class="glyphicon glyphicon-user"></span>&nbsp;Users</a></li>
                                <li v-if="userIsAdmin"><a href="/admin-center/newsletters"><span class="glyphicon glyphicon-envelope"></span>&nbsp;Newsletters</a></li>
                                <li v-if="userIsAdmin" v-text=""class="divider"></li>
                                <li><a href="/auth/logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log out</a></li>
                            </ul>
                        </li>
                        <!-- END User email and dropdown -->

                        <li>
                            <p class="navbar-btn">
                                <a href="/submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;Submit page</a>
                            </p>
                        </li>
                    </ul>
                    <!-- END Navbar right menus -->

                </div>
            </div>
            <!-- END Container -->
        </div>
    </nav>
    <!-- END Navbar static top -->

    <connect-modal></connect-modal>
    <upload-page-modal></upload-page-modal>

</template>

<script>
    import ConnectModal from '../components/modals/ConnectModal.vue';
    import UploadPageModal from '../components/modals/UploadPageModal.vue';

    export default {

        components: {
            'connect-modal': ConnectModal,
            'upload-page-modal': UploadPageModal,
        },

        data: function() {
            return {
                serverData: '',
                activePage: '',
            }
        },

        ready: function() {
            // Request navigation bar data from server
            this.$dispatch('loadingNavigationBar');
        },

        methods: {
            showConnectModal: function() {
                this.$broadcast('showConnectModal');
            },

            showUploadPageModal: function() {
                this.$broadcast('showUploadPageModal');
            },
        },

        computed: {
            userIsLoggedIn: function() {
                if (this.serverData.loggedIn) {
                    return true;
                }
                return false;
            },

            userIsAdmin: function() {
                if (this.serverData.isAdmin) {
                    return true;
                }
                return false;
            },

            favoritesIsTheActivePage: function() {
                if (this.activePage === 'favorites') {
                    return true;
                }
                return false;
            },

            randomIsTheActivePage: function() {
                if (this.activePage === 'random') {
                    return true;
                }
                return false;
            },

        },

        events: {
            /**
             * Get navigation bar data from server.
             */
            'sendingNavigationBarData': function(data) {
                this.serverData = data;
            },

            'setFavoritesAsActivePage': function() {
                this.activePage = 'favorites';
            },

            'setRandomAsActivePage': function() {
                this.activePage = 'random';
            },
        }
    }
</script>
