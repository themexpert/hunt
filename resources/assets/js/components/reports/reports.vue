<template>
    <section class="main-content reports">
    <div class="banner blue darken-2">
        <div class="container">
            <div class="feature-req">
                <div class="center-align feature-form-area">
                    <h2 class="feature-req-title">Feature Reports</h2>
                </div>
            </div><!--/.feature-req-->
        </div>
    </div><!--/.banner-->

    <div class="container mt30">
        <div class="row">
            <div class="col s3">
                <access-filter></access-filter>
                <tags-filter></tags-filter>
            </div>
            <reports-list></reports-list>
        </div>
    </div>
</section>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../config/Hunt'
    import AccessFilter from './components/access-filter.vue'
    import TagsFilter from './components/tags-filter.vue'
    import ReportsList from './components/reports-list.vue'
    export default{
        name: 'ReportsPage',
        components: {
            'access-filter': AccessFilter,
            'tags-filter': TagsFilter,
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
