<template>
    <div id="manage-newsletter-pages-modal" class="modal fade" role="dialog">
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
                            <div class="form-group">
                                <label>{{ newsletter.name }}</label>
                                <input type="text" class="form-control" />
                            </div>

                            <!-- BEGIN Pages added since last newsletter created -->
                            <span>Number of added pages: <strong>{{ selectedPages.length }}</strong></span>
                            <div class="panel panel-default">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Page name</th>
                                            <th class="text-center">Page url</th>
                                            <th class="text-center">Add/Remove</th>
                                        </tr>
                                        </thead>
                                    <tbody>
                                        <tr v-for="page in latestPages">
                                            <td class="text-center vert-align">{{ page.name }}</td>
                                            <td class="text-center vert-align"><a :href="page.url" target="_blank">{{ page.url }}</a></td>
                                            <td class="text-center vert-align">
                                                <div v-if="!pageIsSelected(page.id)" @click="selectPage(page.id)" class="btn btn-success">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </div>
                                                <div v-if="pageIsSelected(page.id)" @click="removePage(page.id)" class="btn btn-danger">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Pages added since last newsletter created -->

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
        //
    }
</script>
