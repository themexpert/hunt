<template>
    <div class="tags">
        <span v-for="(tag, key) in tags" class="chip" :class="{green:key%2==0}"> {{ tag.name }} </span>
    </div>
</template>
<style>
    
</style>
<script>
    export default{
        props: ['tags'],
        data(){
            return{
            }
        }
    }
</script>
