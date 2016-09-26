<template>
    <div>
        <h4>Accepted pages</h4>
        <div v-if="existsAcceptedPages" class="panel panel-default">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Page name</th>
                        <th class="text-center">Page url</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="page in acceptedPages">
                        <td class="text-center">{{ page.name }}</td>
                        <td class="text-center">{{ page.url }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="!existsAcceptedPages" class="alert alert-info">Looks like there are no accepted pages at the moment.</div>

    </div>
</template>

<script>
    export default {
        props: ['acceptedPages'],

        computed: {
            existsAcceptedPages: function() {
                for (var page in this.acceptedPages) {
                    return true;
                }
                return false;
            },
        }
    }
</script>
