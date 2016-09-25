<template>
    <div id="upload-page-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ modal.title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">

                            <div v-show="hasError" class="alert alert-danger">{{ hasError }}</div>
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
        // ready: function() {
        //     this.showModal();
        // },
        data: function() {
            return {
                page: {
                    name: '',
                    url: '',
                    image: '',
                    imageSource: '',
                },
                modal: {
                    selector: '#upload-page-modal',
                    title: 'Upload page',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Upload',
                },
                errors: {
                    pageName: '',
                    pageUrl: '',
                    pageImage: '',
                },
                error: '',
                callbackToExecuteAfterUploadingPage: '',
            }
        },

        methods: {
            showModal: function(page, callback) {
                // if (typeof page === 'undefined') {
                    $(this.modal.selector).modal('show');
                    // return;
                // }

                this.page.name = 'page.name';
                this.page.url = 'page.url';
                console.log(page);
                // var vm = this;
                // vm.page.name = 'bau';
                // vm.page.url = 'http://bitller.com';
                // $(this.modal.selector).modal('show');
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
                    if (vm.callbackToExecuteAfterUploadingPage) {
                        vm.callbackToExecuteAfterUploadingPage();
                        return;
                    }
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

            populateModal: function(pageId, callback) {
                // Do server request
                var vm = this;
                this.page.name = 'sssss';
                this.$http.get('/admin-center/upload-page/get-page-details/' + pageId).then(function(success) {
                    // Populate page name and url
                    // vm.$nextTick(function() {
                    //     vm.page.name = success.data.page_name;
                    //     vm.page.url = success.data.page_url;
                    // });



                    // Set callback to be executed after uploading the image and then finally show the modal
                    vm.callbackToExecuteAfterUploadingPage = callback;
                    vm.showModal();
                }, function(error) {
                    //
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
            'showUploadPageModal': function(page, callback) {
                if (typeof page === 'undefined') {
                    this.showModal();
                    return;
                }
                console.log('called from l236');
                this.page.name = 'bal';
                this.showModal(page, callback);
                // Event fired from pending pages, so populate page name and url and let the admin only to upload the image
                // this.populateModal(pageId, callback);
            },

            'a': function() {
                this.a = 'ssss';
            }
        },
    }
</script>
