<template>
    <div v-if="feature==null" class="col s4">
        <preloader></preloader>
    </div>
    <div class="col s4" v-else>
        <div class="widget widget-action">
            <h3 class="widget-title mt0" v-text="lang.panel_title.action">Action</h3>
            <vote v-if="!currentUserIsCreator && !isAdmin && ['RELEASED', 'DECLINED'].indexOf(feature.status.type)<0" :feature="feature" single></vote>
            <admin v-else :feature="feature"></admin>
        </div><!--/.widget-->

        <!-- Feature feedback -->
        <div class="widget widget-feedback">
            <h3 class="widget-title" v-text="lang.panel_title.feedback">Feature Feedback</h3>
            <div class="card">
                <div class="card-content">
                    <div class="clearfix"><i class="material-icons left">done</i> {{ upVote }} <span v-text="lang.panel_text.action.interested">people want this</span></div>
                    <div class="clearfix"><i class="material-icons left">snooze</i> {{ downVote }} <span v-text="lang.panel_text.action.not_interested">not interested</span></div>
                </div>
            </div>
        </div><!--/.widget-->

        <!-- Want this -->
        <div class="widget widget-feedback">
            <h3 class="widget-title">Want This</h3>
            <div class="card">
                <div class="card-content">
                    <div v-if="upVoters.length > 0">
                        <ul>
                            <li v-for="upVoter in upVoters">
                                <div>
                                     <img :src="gravatar(upVoter.email)" data-position="top" :data-tooltip="upVoter.name" :alt="upVoter.name" class="circle" height="35" width="35">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <b> No record found</b>
                    </div>
                </div>
            </div>
        </div><!--/.widget-->


        <!-- Not interested -->
        <div class="widget widget-feedback">
            <h3 class="widget-title">Not Interested</h3>
            <div class="card">
                <div class="card-content">
                    <div v-if="downVoters.length > 0">
                        <ul>
                            <li v-for="downVoter in downVoters">
                                <div>
                                    <img :src="gravatar(downVoter.email)" data-position="top" :data-tooltip="downVoter.name" :alt="downVoter.name" class="circle" height="35" width="35">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div v-else>
                        <b> No record found</b>
                    </div>
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
    import Admin_panel from './components/admin.vue'
    import Hunt from '../../../config/Hunt'
    export default{
        name: 'SingleFeatureSidebar',
        props: ['feature'],
        components: {
            'preloader': preloader,
            'status-update-modal': StatusUpdateModal,
            'effort-update-modal': EffortUpdateModal,
            'priority-update-modal': PriorityUpdateModal,
            'vote': vote,
            'admin': Admin_panel
        },
        data(){
            return{
                upVoters: [],
                downVoters: []
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
        },

         mounted () {
            setTimeout(() => {
                this.get('/features/' + this.feature.id +'/up')
                    .then(
                        success => {
                         this.upVoters = success.body
                        }
                    );

                this.get('/features/' + this.feature.id +'/down')
                    .then(
                        success => {
                         this.downVoters = success.body
                        }
                    );
            }, 1000);

            Vue.nextTick(()=>{
                this.re_render();
            });
         },

        methods: {
            /**
             * Gravatar URL from email
             *
             * @param email
             * @param size
             * @returns {string}
             */
            gravatar(email, size) {
                return 'http://gravatar.com/avatar/'+Hunt.md5(email)+'?r=pg&d=mm'+(size?'&s='+size:'');
            },

            /**
             * re render tooltip
             */
            re_render() {
                setTimeout(()=>{
                    const tooltip = $("img[data-tooltip]");
                    tooltip.tooltip('remove');
                    tooltip.tooltip();
                }, 2000);
            }
        }
    }
</script>
