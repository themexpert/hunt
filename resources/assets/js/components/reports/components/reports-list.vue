<template>
    <div class="col s9">
        <div class="card mt0">
            <div class="card-content report-table">
                <table class="responsive-table reports-list">
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
                        <tr v-if="loading">
                            <td colspan="3"><preloader-2></preloader-2></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!--/.feature-req-->
    </div>
</template>
<style>
    
</style>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    import ListItem from './components/list-item.vue'
    import preloader_2 from '../../preloader-2.vue'
    export default{
        name: 'ReportsList',
        components: {
            'list-item': ListItem,
            'preloader-2': preloader_2
        },
        data(){
            return{
                loading: true
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
            Hunt.infiniteScroll('.reports-list', ()=>{
                this.loading = true;
                this.$store.commit('loadFeatures', true);
            });
            Bus.$on('reports-list-loaded', ()=>{this.loading = false;});
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
