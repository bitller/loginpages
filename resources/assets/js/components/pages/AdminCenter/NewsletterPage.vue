<style>
.inline-block {
    display: inline-block;
}
</style>

<template>

    <div class="row">
        <div class="col-md-12">
            <h4 class="inline-block">Newsletters</h4>
            <div @click="showCreateNewsletterModal" class="btn btn-info pull-right inline-block"><span class="glyphicon glyphicon-plus"></span>&nbsp;Create newsletter</div>

            <div v-if="!existsNewsletters" class="alert alert-info">Looks like there are no newsletters created.</div>

            <div v-if="existsNewsletters" class="panel panel-default">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Number</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Pages</th>
                            <th class="text-center">Created at</th>
                            <th class="text-center">Sent at</th>
                            <th class="text-center">Manage pages</th>
                            <th class="text-center">Send</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="newsletter in newsletters.data">
                            <td class="text-center vert-align">{{ newsletter.number }}</td>
                            <td class="text-center vert-align">{{ newsletter.name }}</td>
                            <td class="text-center vert-align">{{ newsletter.pages }}</td>
                            <td class="text-center vert-align">{{ newsletter.created_at }}</td>
                            <td class="text-center vert-align">{{ displaySentAt(newsletter) }}</td>

                            <!-- BEGIN Manage pages -->
                            <td class="text-center vert-align">
                                <div @click="showManageNewsletterPagesModal(nesletter)" :class="{ 'disabled': newsletter.sent }" class="btn btn-info">
                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp;Manage
                                </div>
                            </td>
                            <!-- END Manage pages -->

                            <!-- BEGIN Send -->
                            <td class="text-center vert-align">
                                <div @click="sendNewsletter(newsletter)" :class="{ 'disabled': newsletter.sent }" class="btn btn-success">
                                    <span class="glyphicon glyphicon-send"></span>&nbsp;Send
                                </div>
                            </td>
                            <!-- END Send -->

                            <!-- BEGIN Delete -->
                            <td class="text-center vert-align">
                                <div @click="deleteNewsletter(newsletter)" :class="{ 'disabled': newsletter.sent }" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-trash"></span>&nbsp;Delete
                                </div>
                            </td>
                            <!-- END Delete -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <create-newsletter-modal></create-newsletter-modal>
    </div>
</template>

<script>
    import CreateNewsletterModal from '../../../components/modals/AdminCenter/CreateNewsletterModal.vue';

    export default {

        components: {
            'create-newsletter-modal': CreateNewsletterModal,
        },

        data: function() {
            return {
                newsletters: '',
            }
        },

        ready: function() {
            this.getNewsletters();
        },

        methods: {

            getNewsletters: function(callback) {
                if (typeof callback === 'undefined') {
                    this.$dispatch('loader');
                }
                var vm = this;
                this.$http.get('/admin-center/newsletters').then(function(success) {
                    vm.newsletters = success.data.newsletters;
                    if (typeof callback === 'undefined') {
                        vm.$dispatch('close_opened_alert');
                        return;
                    }
                    callback();
                }, function(error) {
                    //
                });
            },

            showManageNewsletterPagesModal: function(newsletter) {
                if (newsletter.sent) {
                    return false;
                }
                this.$broadcast('showManageNewsletterPagesModal', newsletter);
            },

            deleteNewsletter: function(newsletter) {
                // Only not sent newsletters can be deleted
                if (newsletter.sent) {
                    return false;
                }

                var vm = this;
                // Ask for confirmation
                var config = {
                    title: 'Are you sure?',
                    message: 'Selected newsletter will be deleted and the operation can not be undone.',
                    confirmButtonText: 'Yes, I\'m sure'
                };
                this.$dispatch('confirm', config, function() {
                    // After admin confrimed, make request to delete newsletter
                    var data = {
                        newsletter_id: newsletter.id
                    };
                    vm.$http.post('/admin-center/newsletters/delete', data).then(function(success) {
                        // Refresh newsletters
                        vm.getNewsletters(function() {
                            vm.$dispatch('success_alert', success.data.title, success.data.title);
                        });
                    }, function(error) {
                        //
                    });
                });
            },

            sendNewsletter: function(newsletter) {
                var vm = this;
                // Ask for confirmation
                var config = {
                    title: 'Are you sure?',
                    message: 'This newsletter will be sent.',
                    confirmButtonText: 'Yes, I\'m sure',
                };
                this.$dispatch('confirm', data, function() {
                    var data = {
                        newsletter_id: newsletter.id,
                    };
                    this.$http.post('/admin-center/newsletter/send', data).then(function(success) {
                        // Refresh newsletters
                        vm.getNewsletters(function() {
                            vm.$dispatch('success_alert', success.data.title, success.data.message);
                        });
                    }, function(error) {
                        //
                    });
                });

            },

            showCreateNewsletterModal: function() {
                this.$broadcast('showCreateNewsletterModal');
            },

            displaySentAt: function(newsletter) {
                if (newsletter.sent_at) {
                    return newsletter.sent_at;
                }
                return 'Not sent';
            },

        },

        computed: {
            existsNewsletters: function() {
                for (var newsletter in this.newsletters.data) {
                    return true;
                }
                return false;
            },
        },

        events: {
            'getNewsletters': function(callback) {
                if (typeof callback === 'undefined') {
                    this.getNewsletters();
                    return;
                }
                this.getNewsletters(callback);
            },
        }

    }
</script>
