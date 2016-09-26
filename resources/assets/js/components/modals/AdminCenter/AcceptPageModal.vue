<template>
    <div id="accept-page-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button @click="closeModal" type="button" class="close">&times;</button>
                    <h4 class="modal-title">{{ modal.title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <!-- <div v-show="hasError" class="alert alert-danger">{{ hasError }}</div> -->

                            <!-- BEGIN Page name -->
                            <div :class="{ 'has-error': pageNameHasError }" class="form-group">
                                <label>Page name</label>
                                <input v-model="page.name" type="text" class="form-control" />
                                <span v-show="pageNameHasError" class="text-danger">{{ pageNameHasError }}</span>
                            </div>
                            <!-- END Page name -->

                            <!-- BEGIN Page url -->
                            <div :class="{ 'has-error': pageUrlHasError }" class="form-group">
                                <label>Page url</label>
                                <input v-model="page.url" type="text" class="form-control" />
                                <span v-show="pageUrlHasError" class="text-danger">{{ pageUrlHasError }}</span>
                            </div>
                            <!-- END Page url -->

                            <!-- BEGIN Page image -->
                            <div class="form-group page-image">
                                <label>Page image</label>
                                <input @change="previewPageImage" type="file" />
                            </div>
                            <!-- END Page image -->

                            <img v-show="showPageImagePreview" width="565px" :src="page.imageSource" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="closeModal" type="button" class="btn btn-default">{{ modal.cancelButtonText }}</button>
                    <div @click="uploadPage" class="btn btn-primary">{{ modal.confirmButtonText }}</div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                page: {
                    id: '',
                    name: '',
                    url: '',
                    image: '',
                    imageSource: '',
                },
                modal: {
                    selector: '#accept-page-modal',
                    title: 'Accept and upload page',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Accept and Upload',
                },
                errors: {
                    pageName: '',
                    pageUrl: '',
                    pageImage: '',
                },
                error: '',
            }
        },

        methods: {

            showModal: function(page) {
                this.page.id = page.id;
                this.page.name = page.name;
                this.page.url = page.url;

                $(this.modal.selector).modal('show');
            },

            closeModal: function() {
                $(this.modal.selector).modal('hide');
                this.emptyErrors();
                this.emptyInputs();
            },

            uploadPage: function() {
                var vm = this;
                this.$dispatch('loader');
                this.emptyErrors();

                // Create the form
                var form = new FormData();
                form.append('page_name', this.page.name);
                form.append('page_url', this.page.url);
                form.append('page_image', this.page.image);

                // Submit to the server
                this.$http.post('/admin-center/upload-page', form).then(function(success) {
                    // After uploading the photo, make the page accepted
                    vm.$http.post('/admin-center/submited-pages/' + vm.page.id + '/accept').then(function(success) {
                        // Now refresh all pages
                        vm.$dispatch('getSubmitedPages', function() {
                            console.log('called after reloading submited pages');
                            vm.closeModal();
                            vm.$dispatch('success_alert', success.data.title, success.data.message);
                        });
                    }, function(error) {
                        //
                    });
                }, function(error) {

                    this.$dispatch('close_opened_alert');

                    if (error.data.page_name) {
                        this.errors.pageName = error.data.page_name;
                    }
                    if (error.data.page_url) {
                        this.errors.pageUrl = error.data.page_url;
                    }
                    if (error.data.page_image) {
                        this.errors.pageImage = error.data.page_image;
                    }

                    if (this.pageNameHasError || this.pageUrlHasError || this.pageImageHasError) {
                        return true;
                    }

                    this.error = 'Ooops. An error occurred. Refresh the page and try again.';
                });
            },

            /**
             * Preview selected image.
             */
            previewPageImage: function(event) {
                // Get input and create a new FileReader instance
                var input = event.target;
                var reader = new FileReader();
                var vm = this;

                reader.onload = function(e) {
                    vm.page.imageSource = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
                vm.page.image = input.files[0];
            },

            emptyErrors: function() {
                this.errors.pageName = this.errors.pageUrl = this.errors.pageImage = this.error = '';
            },

            emptyInputs: function() {
                this.page.name = this.page.url = this.page.image = this.page.imageSource = '';
                // todo empty input file when closing modal
                // $('.page-image').html($('.page-image').html());
            }
        },

        computed: {
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

            pageImageHasError: function() {
                if (this.errors.pageImage) {
                    return this.errors.pageImage;
                }
                return false;
            },

            hasError: function() {
                if (this.error) {
                    return this.error;
                }
                return false;
            },

            showPageImagePreview: function() {
                if (this.page.imageSource) {
                    return true;
                }
                return false;
            },
        },

        events: {
            'showAcceptPageModal': function(page) {
                this.showModal(page);
            }
            // 'showUploadPageModal': function() {
            //     this.showModal();
            // },
        }
    }
</script>
