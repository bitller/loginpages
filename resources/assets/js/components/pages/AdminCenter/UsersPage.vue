<template>

    <div class="row">

        <!-- BEGIN Total users -->
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading text-center">Total users</div>
                <div class="panel-body text-center"><h4>{{ registeredUsers.total }}</h4></div>
            </div>
        </div>
        <!-- END Total users -->

        <!-- BEGIN Registered users with Google -->
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading text-center">Google users</div>
                <div class="panel-body text-center"><h4>{{ registeredUsers.google }}</h4></div>
            </div>
        </div>
        <!-- END Registered users with Google -->

        <!-- BEGIN Registered users with Facebook -->
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading text-center">Facebook users</div>
                <div class="panel-body text-center"><h4>{{ registeredUsers.facebook }}</h4></div>
            </div>
        </div>
        <!-- END Registered users with Facebook -->

        <!-- BEGIN Registered users with Github -->
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading text-center">Github users</div>
                <div class="panel-body text-center"><h4>{{ registeredUsers.github }}</h4></div>
            </div>
        </div>
        <!-- END Registered users with Github -->

        <div class="col-md-12">
            <div class="panel panel-default">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Sign Up Date</th>
                            <th class="text-center">Provider</th>
                            <th class="text-center">Subscribed</th>
                            <th class="text-center">Disable/Enable account</th>
                            <th class="text-center">Delete account</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data">
                            <td class="text-center vert-align">{{ user.name }}</td>
                            <td class="text-center vert-align">{{ user.email }}</td>
                            <td class="text-center vert-align">{{ user.created_at }}</td>
                            <td class="text-center vert-align">{{ userProviderById(user) }}</td>
                            <td class="text-center vert-align">{{ userHasSubscription(user) }}</td>
                            <td class="text-center vert-align">
                                <div @click="enableAccount(user.id)" v-if="user.disabled" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;Enable</div>
                                <div @click="disableAccount(user.id)" v-if="!user.disabled" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Disable</div>
                            </td>
                            <td class="text-center vert-align">
                                <div @click="deleteAccount(user.id)" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp;Delete
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        data: function() {
            return {
                users: '',
                registeredUsers: '',
            }
        },

        ready: function() {
            this.getUsers();
        },

        methods: {
            getUsers: function(callback) {
                this.$dispatch('loader');
                var vm = this;

                // Make request
                this.$http.get('/admin-center/users').then(function(success) {
                    vm.users = success.data.users;
                    vm.registeredUsers = success.data.registered_users;
                    if (typeof callback === 'undefined') {
                        vm.$dispatch('close_opened_alert');
                        return;
                    }
                    callback();
                }, function(error) {
                    //
                });
            },

            enableAccount: function(userId) {
                var vm = this;

                // Ask for confirmation
                var config = {
                    title: 'Are you sure?',
                    message: 'This account will be enabled, allowing owner to log in again.',
                    confirmButtonText: 'Yes, I\'m sure',
                };
                this.$dispatch('confirm', config, function() {
                    // After admin confirmed, make request to enable the account
                    var data = {
                        user_id: userId,
                    };
                    vm.$http.post('/admin-center/users/enable-account', data).then(function(success) {
                        // Reload users
                        vm.getUsers(function() {
                            vm.$dispatch('success_alert', success.data.title, success.data.message);
                        });
                    }, function (error) {
                        //
                    });
                });
            },

            disableAccount: function(userId) {
                var vm = this;

                // Ask for confirmation
                var config = {
                    title: 'Are you sure?',
                    message: 'This account will be disabled. Owner will no longer have access to it.',
                    confirmButtonText: 'Yes, I\'m sure',
                };
                this.$dispatch('confirm', config, function() {
                    // Make request to disable the account after admin confirmed
                    var data = {
                        user_id: userId,
                    };
                    vm.$http.post('/admin-center/users/disable-account', data).then(function(success) {
                        // Reload users
                        vm.getUsers(function() {
                            vm.$dispatch('success_alert', success.data.title, success.data.message);
                        });
                    }, function(error) {
                        //
                    });
                });
            },

            deleteAccount: function(userId) {
                var vm = this;

                // Ask for confirmation
                var config = {
                    title: 'Are you sure?',
                    message: 'Selected account will be deleted. This action can not be undone.',
                    confirmButtonText: 'Yes, I\'m sure',
                };
                this.$dispatch('confirm', config, function() {
                    // Make request to delete the account after admin confirmed the action
                    var data = {
                        user_id: userId,
                    };
                    vm.$http.post('/admin-center/users/delete-account', data).then(function(success) {
                        // Reload users
                        vm.getUsers(function() {
                            vm.$dispatch('success_alert', success.data.title, success.data.message);
                        });
                    }, function(error) {
                        //
                    });
                })
            },

            userProviderById: function(user) {
                if (user.google_id) {
                    return 'Google';
                }
                if (user.facebook_id) {
                    return 'Facebook';
                }
                if (user.github_id) {
                    return 'Github';
                }
            },

            userHasSubscription: function(user) {
                if (user.subscription && user.subscription.id) {
                    return 'Yes';
                }
                return 'No';
            },
        },

        computed: {
            //
        }

    }
</script>
