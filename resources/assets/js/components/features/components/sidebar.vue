<template>
    <div v-if="feature==null" class="col s4">
        <preloader></preloader>
    </div>
    <div v-else class="col s4">
        <div class="widget widget-action">
            <h3 class="widget-title mt0">Action</h3>
            <vote :item-id="feature.id" :voted="feature.vote.voted" single></vote>
        </div><!--/.widget-->

        <div class="widget widget-feedback">
            <h3 class="widget-title">Feature Feedback</h3>
            <div class="card">
                <div class="card-content">
                    <div class="clearfix"><i class="material-icons left">done</i> {{ upVote }} people want this</div>
                    <div class="clearfix"><i class="material-icons left">snooze</i> {{ downVote }} not interested</div>
                </div>
            </div>
        </div><!--/.widget-->
        <status-update-modal v-if="isAdmin" :feature-id="feature.id"></status-update-modal>
    </div><!--/.col-->
</template>
<style>
    
</style>
<script type="text/babel">
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
            /**
             * Register new vote listener
             */
            Bus.$on('new-vote', vote=>{
                if(this.feature.vote==null) this.feature.vote = {up: 0, down: 0};
                if(vote.up)
                    this.feature.vote.up++;
                else
                    this.feature.vote.down++;
            });
        },
        computed: {
            /**
             * Gives up vote for feature request
             *
             * @returns {number}
             */
            upVote() {
                return this.feature!=undefined && this.feature.vote!=null? this.feature.vote.up:0;
            },
            /**
             * Gives down vote for feature request
             *
             * @returns {number}
             */
            downVote() {
                return this.feature!=undefined && this.feature.vote!=null? this.feature.vote.down:0;
            }
        }
    }
</script>
