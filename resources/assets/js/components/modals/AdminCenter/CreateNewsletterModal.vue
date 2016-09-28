<template>
    <div id="create-newsletter-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click="closeModal">&times;</button>
                    <h4 class="modal-title">{{ modal.title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div v-show="hasError" class="alert alert-danger">{{ hasError }}</div>

                            <!-- BEGIN Newsletter name -->
                            <div :class="{ 'has-error': newsletterNameHasError }" class="form-group">
                                <label>Newsletter name</label>
                                <input v-model="newsletterName" @keyup.enter="createNewsletter" type="text" class="form-control" />
                                <span v-show="newsletterNameHasError" class="text-danger">{{ newsletterNameHasError }}</span>
                            </div>
                            <!-- END Newsletter name -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="closeModal" type="button" class="btn btn-default">{{ modal.cancelButtonText }}</button>
                    <div @click="createNewsletter" class="btn btn-primary">{{ modal.confirmButtonText }}</div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {

        data: function() {
            return {
                newsletterName: '',
                modal: {
                    selector: '#create-newsletter-modal',
                    title: 'Create Newsletter',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Create',
                },
                errors: {
                    newsletterName: '',
                },
                error: '',
            }
        },

        methods: {

            showModal: function() {
                $(this.modal.selector).modal('show');
            },

            closeModal: function() {
                $(this.modal.selector).modal('hide');
                this.emptyInputs();
                this.emptyErrors();
            },

            createNewsletter: function() {
                var vm = this;
                this.$dispatch('loader');
                this.emptyErrors();

                var data = {
                    newsletter_name: this.newsletterName,
                };
                this.$http.post('/admin-center/newsletters', data).then(function(success) {
                    vm.$dispatch('getNewsletters', function() {
                        vm.closeModal();
                        vm.$dispatch('success_alert', success.data.title, success.data.message);
                    });
                }, function(error) {
                    vm.$dispatch('close_opened_alert');
                    if (error.data.newsletter_name) {
                        vm.errors.newsletterName = error.data.newsletter_name;
                    }

                    if (!vm.newsletterNameHasError) {
                        this.error = 'An error occurred. Refresh the page and try again.';
                    }
                });
            },

            emptyErrors: function() {
                this.errors.newsletterName = this.error = '';
            },

            emptyInputs: function() {
                this.newsletterName = '';
            }
        },

        computed: {
            newsletterNameHasError: function() {
                if (this.errors.newsletterName) {
                    return this.errors.newsletterName;
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
            'showCreateNewsletterModal': function() {
                this.showModal();
            },
        },
    }
</script>
