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
                <img :src="gravatar(feature.user.email)" alt="" class="circle"><a>{{ feature.user.name }}</a> created this feature request {{ getDateDiffFromToday(feature.created_at) }} ago
            </div>
        </div><!--/.card-->

        <h2 class="title">Status <span class="chip green">{{ feature.status.type }}</span></h2>
        <div class="card">
            <div class="card-content">
                <span class="card-title quote">{{ feature.status.subject }}</span>
            </div>
            <div class="card-action user-info">
                <img :src="gravatar(feature.user.email)" alt="" class="circle"><a>{{ feature.user.name }}</a> created this feature request {{ getDateDiffFromToday(feature.created_at) }} ago
            </div>
        </div><!--/.card-->

        <h2 class="title">Discussion</h2>
        <div class="card comments">
            <div class="card-content">
                <comments :feature-id="feature.id"></comments>
            </div>
            <add-comment-modal :feature-id="feature.id"></add-comment-modal>
        </div><!--/.card-->
    </div><!--/.col-->
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../config/Hunt'
    import Comments from './components/comments.vue'
    import AddCommentModal from './components/add-comment-modal.vue'
    import preloader from '../../preloader.vue'
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
        methods: {
            getDateDiffFromToday(date) {
                let diff = this.getDateDiff(new Date(), new Date(date));
                if(diff<30) {
                    return diff + ' day(s)';
                }
                return Math.floor((diff/30)) + ' month(s)';
            }
        }
    }
</script>
