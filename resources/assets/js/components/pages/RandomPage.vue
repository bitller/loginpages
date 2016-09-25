<style>
.center-image {
    margin: 0 auto;
}
.margin-top {
    margin-top: 10px;
}
.max-width {
    max-width: 900px;
}
.image-shadow {
    box-shadow: 0 0 10px #cacaca; 
}
</style>
<template>
<div class="col-md-12">
    <div class="col-md-12 text-center"><h3><a href="#">FrontApp</a></h3></div>
    <img class="img-responsive center-image max-width image-shadow" src="/img/register.png" />
    <div class="col-md-6 col-md-offset-3 text-center">
        <div class="row margin-top">
            <div class="col-md-12">
                <div class="btn btn-success btn-block btn-lg">Show me another random log in page</div>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-md-6">
                <div class="btn btn-default btn-block"><span class="glyphicon glyphicon-heart"></span>&nbsp;Upvote</div>
            </div>
            <div class="col-md-6">
                <div class="btn btn-default btn-block"><span class="glyphicon glyphicon-star"></span>&nbsp;Favorite</div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
    export default {

        ready: function() {
            this.$dispatch('loadingRandomPage');
        },



    }
</script>
