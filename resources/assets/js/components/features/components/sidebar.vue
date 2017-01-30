<template>
    <div v-if="feature==null" class="col s4">
        <preloader></preloader>
    </div>
    <div v-else class="col s4">
        <div class="widget widget-action">
            <h3 class="widget-title mt0">Action</h3>
            <vote :item-id="feature.id" single></vote>
        </div><!--/.widget-->

        <div class="widget widget-feedback">
            <h3 class="widget-title">Feature Feedback</h3>
            <div class="card">
                <div class="card-content">
                    <div class="clearfix"><i class="material-icons left">done</i> {{ feature.vote.up }} people want this</div>
                    <div class="clearfix"><i class="material-icons left">snooze</i> {{ feature.vote.down }} not interested</div>
                </div>
            </div>
        </div><!--/.widget-->
        <status-update-modal v-if="isAdmin" :feature-id="feature.id"></status-update-modal>
    </div><!--/.col-->
</template>
<style>
    
</style>
<script>
    import preloader from '../../preloader.vue'
    import vote from './components/vote.vue'
    import StatusUpdateModal from './components/status-update-modal.vue'
    export default{
        name: 'SingleFeatureSidebar',
        props: ['feature'],
        components: {
            'preloader': preloader,
            'status-update-modal': StatusUpdateModal,
            'vote': vote
        },
        data(){
            return{
            }
        },
        mounted() {
            Bus.$on('new-vote', vote=>{
                if(vote.up)
                    this.feature.vote.up++;
                else
                    this.feature.vote.down++;
            });
        }
    }
</script>
