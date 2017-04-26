<template>
    <div class="widget widget-feature-filter">
        <h3 class="widget-title" v-text="lang.panel_title.prepared_reports">Prepared Reports</h3>
        <div class="filter-btn">
            <router-link class="waves-effect waves-light btn" v-for="(slug, label) in filters" :to="getUrl(slug)" :class="{active: filter==slug}">{{ label }}</router-link>
            <router-link class="waves-effect waves-light btn" :to="graphUrl" :class="{active: filter=='effortVsValue'}">{{ graphLabel }}</router-link>
        </div>
    </div><!--/.widget-->
</template>
<style>

</style>
<script>
    export default{
        name: 'PreparedReportFilter',
        data(){
            return{
                filters: {
                    'Popular Vote': 'popularVote',
                    'Low Vote': 'lowPopularVote',
                    'High Value': 'highValue',
                    'Mid Value': 'midValue',
                    'Low Value': 'lowValue'
                }
            }
        },
        methods: {
            /**
             * Generates filter url from tags id
             *
             * @param tagId
             * @returns {string}
             */
            getUrl(tagId) {
                return '/reports/filter/prepared/'+tagId;
            }
        },
        computed: {
            /**
             * Get tags from store
             *
             * @returns {computed.tags|null|Array|*}
             */
            tags() {
                return this.$store.state.features.tags;
            },
            /**
             * Gets current filter
             */
            filter() {
                if(this.$route.params==null || (this.$route.params.type!='prepared' && this.$route.params.type!='graph')) return '';
                return this.$route.params.value;
            },
            /**
             * Gives the graph URL
             *
             * @returns {string}
             */
            graphUrl() {
                return '/reports/filter/graph/effortVsValue';
            },
            /**
             * Gives Graph URL label
             *
             * @returns {string}
             */
            graphLabel() {
                return "Effort VS Priority";
            }
        }
    }
</script>
