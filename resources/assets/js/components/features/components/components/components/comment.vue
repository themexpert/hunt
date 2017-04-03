<template>
    <li class="collection-item avatar">
        <img :src="gravatar(comment.user.email)" alt="" class="circle">
        <span class="title">{{ comment.user.name }}</span>
        <p>{{ comment.message }}</p>
        <a class="secondary-content">{{ getTimeDiff }}</a>
    </li>
</template>
<style>
    
</style>
<script>
    export default{
        name: 'SingleCommentItem',
        props: ['comment'],
        data(){
            return{
            }
        },
        computed: {
            /**
             * Gives the time difference from now in human readable format
             *
             * @returns {string|*}
             */
            getTimeDiff() {
                return moment.tz(this.comment.created_at, 'UTC').tz(moment.tz.guess()).fromNow();
            }
        }
    }
</script>
