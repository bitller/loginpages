<template>
    <h4>Pending pages</h4>
    <div v-if="existsPendingPages" class="panel panel-default">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Page name</th>
                    <th class="text-center">Page url</th>
                    <th class="text-center">Accept</th>
                    <th class="text-center">Decline</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="page in pendingPages">
                    <td class="text-center vert-align">{{ page.name }}</td>
                    <td class="text-center vert-align"><a target="_blank" :href="page.url">{{ page.url }}</a></td>
                    <td class="text-center vert-align"><div @click="showAcceptPageModal(page)" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></div></td>
                    <td class="text-center vert-align"><div @click="declinePage(page.id)" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></div></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="!existsPendingPages" class="alert alert-info">Looks like there are no pending pages at the moment.</div>

    <!-- <upload-page-modal></upload-page-modal> -->
    <accept-page-modal></accept-page-modal>

</template>

<script>
    // import UploadPageModal from '../../../../components/modals/UploadPageModal.vue';
    import AcceptPageModal from '../../../../components/modals/AdminCenter/AcceptPageModal.vue';

    export default {

        props: ['pendingPages'],

        components: {
            // 'upload-page-modal': UploadPageModal,
            'accept-page-modal': AcceptPageModal,
        },

        methods: {
            acceptPage: function(pageId) {
                this.$dispatch('loader');
                var vm = this;
                this.$http.post('/admin-center/submited-pages/' + pageId + '/accept').then(function(success) {
                    //
                }, function(error) {
                    //
                });
            },

            showAcceptPageModal: function(page) {
                this.$broadcast('showAcceptPageModal', page);
            },

            declinePage: function(pageId) {
                var vm = this;
                var data = {
                    title: 'Are you sure?',
                    message: 'This page will be declined.',
                    confirmButtonText: 'Yes, decline page!',
                };
                this.$dispatch('confirm', data, function() {
                    vm.$http.post('/admin-center/submited-pages' + pageId + '/decline').then(function(success) {
                        //
                    }, function(error) {
                        //
                    });
                });
            }
        },

        computed: {
            existsPendingPages: function() {
                for (var page in this.pendingPages) {
                    return true;
                }
                return false;
            },
        }

    }
</script>
