<template>
    <div>
        <pending-pages :pending-pages="pages.pending"></pending-pages>
        <declined-pages :declined-pages="pages.declined"></declined-pages>
        <accepted-pages :accepted-pages="pages.accepted"></accepted-pages>
    </div>
</template>

<script>
    import PendingPages from '../../../components/pages/AdminCenter/SubmitedPagesPage/PendingPages.vue';
    import DeclinedPages from '../../../components/pages/AdminCenter/SubmitedPagesPage/DeclinedPages.vue';
    import AcceptedPages from '../../../components/pages/AdminCenter/SubmitedPagesPage/AcceptedPages.vue';

    export default {
        components: {
            'pending-pages': PendingPages,
            'declined-pages': DeclinedPages,
            'accepted-pages': AcceptedPages,
        },

        ready: function() {
            this.getSubmitedPages();
        },

        data: function() {
            return {
                pages: '',
            }
        },

        methods: {
            getSubmitedPages: function(callback) {
                var vm = this;
                this.$http.get('/admin-center/submited-pages').then(function(success) {
                    vm.pages = success.data.pages;
                    if (typeof callback !== 'undefined') {
                        
                    }
                }, function(error) {
                    vm.error = 'Ooops. An error occurred. Please refresh the page and try again.';
                });
            }
        }
    }
</script>
