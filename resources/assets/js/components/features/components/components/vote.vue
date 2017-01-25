<template>
    <div class="secondary-content">
        <a class="waves-effect waves-light btn teal"><i class="material-icons left">done</i> I want this</a>
        <a class="waves-effect waves-light btn teal lighten-2"><i class="material-icons left">snooze</i> Not interested</a>
    </div>
</template>
<style>
    
</style>
<script>
    export default{
        props: ['votes', 'item-id'],
        data(){
            return{
                msg:'hello vue'
            }
        }
    }
</script>
