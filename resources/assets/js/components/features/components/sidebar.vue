<template>
    <div class="col s4">
        <div class="widget widget-action">
            <h3 class="widget-title mt0">Action</h3>
            <vote single></vote>
        </div><!--/.widget-->

        <div class="widget widget-feedback">
            <h3 class="widget-title">Feature Feedback</h3>
            <div class="card">
                <div class="card-content">
                    <div class="clearfix"><i class="material-icons left">done</i> 157 people want this</div>
                    <div class="clearfix"><i class="material-icons left">snooze</i> 15 not interested</div>
                </div>
            </div>
        </div><!--/.widget-->
        <status-update-modal></status-update-modal>
    </div><!--/.col-->
</template>
<style>
    
</style>
<script>
    import vote from './components/vote.vue'
    import StatusUpdateModal from './components/status-update-modal.vue'
    export default{
        name: 'SingleFeatureSidebar',
        props: [],
        components: {
            'status-update-modal': StatusUpdateModal,
            'vote': vote
        },
        data(){
            return{
                msg:'hello vue'
            }
        },
        mounted() {

        }
    }
</script>
