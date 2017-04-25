<template>
    <div v-if="feature==null" class="col s8">
        <preloader></preloader>
    </div>
    <div v-else class="col s8">
        <h1 class="title mt0">{{ feature.name }}</h1>

        <div class="card">
            <div class="card-content">
                <p>{{ feature.description }}</p>
            </div>
            <div class="card-action user-info">
                <img :src="gravatar(feature.user.email)" width="25" height="25" alt="" class="circle"><a>{{ feature.user.name }}</a> created this feature request {{ getTimeDiff }}
            </div>
        </div><!--/.card-->

        <h2 class="title"><span v-text="lang.panel_title.status">Status</span> <span class="chip green">{{ feature.status.type }}</span></h2>
        <div class="card">
            <div class="card-content">
                <span class="card-title quote">{{ feature.status.subject }}</span>
            </div>
            <div class="card-action user-info">
                <p v-text="feature.status.message"></p>
            </div>
        </div><!--/.card-->

        <h2 class="title" v-text="lang.panel_title.discussion">Discussion</h2>
        <div class="card comments">
            <div class="card-content">
                <comments :feature-id="feature.id"></comments>
            </div>
            <add-comment-modal v-if="feature.status.type!=='RELEASED'" :feature-id="feature.id"></add-comment-modal>
        </div><!--/.card-->
    </div><!--/.col-->
</template>
<style>
    
</style>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    import Comments from './components/comments.vue'
    import AddCommentModal from './components/add-comment-modal.vue'
    import preloader from '../../helpers/preloader.vue'
    export default{
        name: 'SingleFeatureItem',
        props: ['feature'],
        components: {
            'comments': Comments,
            'add-comment-modal': AddCommentModal,
            'preloader': preloader
        },
        data(){
            return{

            }
        },
        mounted() {
            /**
             * Register status updated listener
             *
             * @type {string}
             */
            Bus.$on('status-updated', status=>{
                this.feature.status.type=status.type;
                this.feature.status.subject=status.subject;
                this.feature.status.message=status.message;
            });
        },
        computed: {
            /**
             * Get time difference from now in human readable format
             *
             * @returns {string|*}
             */
            getTimeDiff() {
                return moment.tz(this.feature.created_at, 'UTC').tz(moment.tz.guess()).fromNow();
            }
        }
    }
</script>
