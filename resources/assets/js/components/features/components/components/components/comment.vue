<template>
    <li class="collection-item avatar">
        <img :src="gravatar(comment.user.email)" alt="" class="circle">
        <span class="title">{{ comment.user.name }}</span>
        <p>{{ comment.message }}</p>
        <a class="secondary-content">{{ getDateDiffFromToday(comment.created_at) }}</i></a>
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
        }
    }
</script>
