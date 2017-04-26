<template>
    <div v-if="feature==null" class="col s4">
        <preloader></preloader>
    </div>
    <div v-else class="col s4">
        <div class="widget widget-action" v-if="['RELEASED', 'DECLINED'].indexOf(feature.status.type)<0">
            <h3 class="widget-title mt0" v-text="lang.panel_title.action">Action</h3>
            <vote :feature="feature" single></vote>
        </div><!--/.widget-->

        <div class="widget widget-feedback">
            <h3 class="widget-title" v-text="lang.panel_title.feedback">Feature Feedback</h3>
            <div class="card">
                <div class="card-content">
                    <div class="clearfix"><i class="material-icons left">done</i> {{ upVote }} <span v-text="lang.panel_text.action.interested">people want this</span></div>
                    <div class="clearfix"><i class="material-icons left">snooze</i> {{ downVote }} <span v-text="lang.panel_text.action.not_interested">not interested</span></div>
                </div>
            </div>
        </div><!--/.widget-->
        <status-update-modal v-if="isAdmin" :feature="feature"></status-update-modal>
        <effort-update-modal v-if="isAdmin && ['RELEASED', 'DECLINED'].indexOf(feature.status.type)<0" :feature="feature"></effort-update-modal>
        <!--<priority-update-modal v-if="currentUserIsCreator" :feature="feature"></priority-update-modal>-->
    </div><!--/.col-->
</template>
<style>
    
</style>
<script type="text/babel">
    import preloader from '../../helpers/preloader.vue'
    import vote from './components/vote.vue'
    import StatusUpdateModal from './components/status-update-modal.vue'
    import EffortUpdateModal from './components/effort-update-modal.vue'
    import PriorityUpdateModal from './components/priority-update-modal.vue'
    export default{
        name: 'SingleFeatureSidebar',
        props: ['feature'],
        components: {
            'preloader': preloader,
            'status-update-modal': StatusUpdateModal,
            'effort-update-modal': EffortUpdateModal,
            'priority-update-modal': PriorityUpdateModal,
            'vote': vote
        },
        data(){
            return{
            }
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
            },
            /**
             * Checks if the current user created this feature request
             *
             * @returns {boolean}
             */
            currentUserIsCreator() {
                return this.$store.state.auth.user.email==this.feature.user.email;
            }
        }
    }
</script>
