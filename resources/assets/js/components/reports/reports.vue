<template>
    <section class="main-content reports">
    <div class="banner blue darken-2">
        <div class="container">
            <div class="feature-req">
                <div class="center-align feature-form-area">
                    <h2 class="feature-req-title" v-text="lang.title_text.reports">Feature Reports</h2>
                </div>
            </div><!--/.feature-req-->
        </div>
    </div><!--/.banner-->

    <div class="container mt30">
        <div class="row">
            <div class="col s3">
                <prepared-report-filter></prepared-report-filter>
                <!--<access-filter></access-filter>-->
                <tags-filter></tags-filter>
            </div>
            <graph v-if="$route.params.type=='graph'"></graph>
            <reports-list v-else></reports-list>
        </div>
    </div>
</section>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../config/Hunt'
    import PreparedReportFilter from './components/prepared-report-filter.vue'
    import AccessFilter from './components/access-filter.vue'
    import TagsFilter from './components/tags-filter.vue'
    import Graph from './components/graph.vue'
    import ReportsList from './components/reports-list.vue'
    export default{
        name: 'ReportsPage',
        components: {
            'prepared-report-filter': PreparedReportFilter,
            'access-filter': AccessFilter,
            'tags-filter': TagsFilter,
            'graph': Graph,
            'reports-list': ReportsList
        },
        data(){
            return{
            }
        },
        mounted() {
            /**
             * Render the page for updated components
             */
            Hunt.renderPage('Reports');
        }
    }
</script>
