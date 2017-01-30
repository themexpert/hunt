<template>
    <div class="col s9">
        <div class="card mt0">
            <div class="card-content report-table">
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th data-field="value">Value</th>
                        <th data-field="feature">Feature</th>
                        <th data-field="status">Status</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr v-if="features.length==0">
                            <td colspan="3">No Feature found</td>
                        </tr>
                        <list-item v-else v-for="feature in features" :feature="feature"></list-item>
                    </tbody>
                </table>
            </div>
        </div><!--/.feature-req-->
    </div>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../config/Hunt'
    import ListItem from './components/list-item.vue'
    export default{
        name: 'ReportsList',
        components: {
            'list-item': ListItem
        },
        data(){
            return{

            }
        },
        mounted() {
            if(this.$route.params.value==undefined) {
                this.$store.dispatch('reloadFeatures', null);
            }
            else {
                this.$store.dispatch('reloadFeatures', {
                    type: this.filter_type,
                    value: this.filter_value
                });
            }
        },
        computed: {
            features() {
                return this.$store.state.reports.features;
            },
            filter_type() {
                return this.$route.params.type;
            },
            filter_value() {
                return this.$route.params.value;
            }
        },
        watch: {
            filter_value() {
                this.$store.dispatch('reloadFeatures', {
                    type: this.filter_type,
                    value: this.filter_value
                });
            }
        }
    }
</script>
