<style>
.btn-google {
    padding-bottom: 13px;
    margin-bottom: 10px;
}
.google-text {
    display: inline-block;
    padding-top: 4px;
}
.btn-facebook {
    padding-bottom: 13px;
    margin-bottom: 10px;
}
.facebook-text {
    display: inline-block;
    padding-top: 4px;
}
.btn-github {
    padding-bottom: 13px;
}
.github-text {
    display: inline-block;
    padding-top: 4px;
}
</style>
<template>
    <div id="connect-modal" class="modal fade" role="dialog">
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
                            <div class="alert alert-info">In order to upvote and add pages to favorites you need to connect with Google, Facebook or Github.</div>
                        </div>

                        <!-- BEGIN Connect with google -->
                        <div class="col-md-6 col-md-offset-3">
                            <a :href="auth.google" class="btn btn-block btn-red btn-lg-custom btn-google">
                                <img src="/img/google.svg" class="pull-left"/><span class="google-text">Connect with Google</span>
                            </a>
                        </div>
                        <!-- END Connect with google -->

                        <!-- BEGIN Connect with facebook -->
                        <div class="col-md-6 col-md-offset-3">
                            <a :href="auth.facebook" class="btn btn-block btn-blue btn-lg-custom btn-facebook">
                                <img src="/img/facebook.svg" class="pull-left"/><span class="facebook-text">Connect with Facebook</span>
                            </a>
                        </div>
                        <!-- END Connect with facebook -->

                        <!-- BEGIN Connect with github -->
                        <div class="col-md-6 col-md-offset-3">
                            <a :href="auth.github" class="btn btn-block btn-grey btn-lg-custom btn-github">
                                <img src="/img/github.svg" class="pull-left"/><span class="github-text">Connect with Github</span>
                            </a>
                        </div>
                        <!-- END Connect with github -->

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ modal.cancelButtonText }}</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                auth: {
                    google: '/auth/google',
                    facebook: '/auth/facebook',
                    github: '/auth/github'
                },
                modal: {
                    selector: '#connect-modal',
                    title: 'Connect with Google, Facebook or GitHub',
                    cancelButtonText: 'Cancel'
                },
            }
        },

        methods: {
            showModal: function() {
                $(this.modal.selector).modal('show');
            },

            closeModal: function() {
                $(this.modal.selector).modal('hide');
            },
        },

        events: {
            'showConnectModal': function() {
                this.showModal();
            },
        },
    }
</script>
