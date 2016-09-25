<style>
    .newsletter-title {
        display: inline-block;
    }
    .newsletter-icon {
        display: inline-block;
        margin-top: 16px;
    }
    .newsletter-divider {
        border-top: 1px solid #ffffff;
        margin-top: 13px;
        margin-bottom: 13px;
        opacity: 0.5;
    }
    .newsletter-description {
        display: inline-block;
        margin-bottom: 20px;
    }
</style>

<template>
    <!-- BEGIN Newsletter -->
    <div class="col-md-10 col-md-offset-1">
        <div class="newsletter">
            <div class="row">
                <div class="col-md-12">

                    <!-- BEGIN Newsletter head -->
                    <div class="newsletter-head">
                        <div class="col-md-12">
                            <h3 class="newsletter-title">Newsletter</h3>
                            <img class="newsletter-icon pull-right" src="/img/mail.svg" />
                            <div class="newsletter-divider"></div>
                            <h4 class="newsletter-description">Join the weekly newsletter and never miss out on new great login pages for your inspiration.</h4>
                        </div>
                    </div>
                    <!-- END Newsletter head -->

                    <!-- BEGIN Newsletter body -->
                    <div class="newsletter-body">
                        <div class="col-md-9">
                            <div class="form-group">
                                <input type="text" class="form-control custom-input" placeholder="Email address" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="btn btn-red btn-lg-custom btn-block">Subscribe</div>
                        </div>
                    </div>
                    <!-- END Newsletter body -->

                </div>
            </div>
        </div>
    </div>
    <!-- END Newsletter -->
</template>
