<template>
    <ul class="collection">
        <comment v-for="comment in comments" :comment="comment"></comment>
    </ul>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../../config/Hunt'
    import comment from './components/comment.vue'
    export default{
        name: 'CommentsList',
        props: ['feature-id'],
        components: {
            'comment': comment
        },
        data(){
            return{
                comments: []
            }
        },
        mounted() {
            /**
             * Register new comment listener
             */
            Bus.$on('new-comment', comment=>{
                this.comments.unshift(comment);
            });
            this.loadComments();
        },
        methods: {
            /**
             * Loads comments for selected feature
             */
            loadComments() {
                this.get('/features/'+this.featureId+'/comments')
                    .then(
                        success=>{
                            this.comments = success.body.data;
                        },
                        fail=>{
                            Hunt.toast('Could not load comments.', 'error');
                            console.log(fail);
                        }
                    );
            }
        }
    }
</script>
