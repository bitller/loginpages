<template>
    <div>
        <h4>Declined pages</h4>
        <div v-if="existsDeclinedPages" class="panel panel-default">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Page name</th>
                        <th class="text-center">Page url</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="page in declinedPages">
                        <td class="text-center">{{ page.name }}</td>
                        <td class="text-center">{{ page.url }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="!existsDeclinedPages" class="alert alert-info">Looks like there are no declined pages.</div>

    </div>
</template>

<script>
    export default {
        props: ['declinedPages'],

        methods: {
            //
        },

        computed: {
            existsDeclinedPages: function() {
                for (var page in this.declinedPages) {
                    return true;
                }
                return false;
            },
        }

    }
</script>
