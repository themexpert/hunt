<template>
    <i class="material-icons circle"> {{ icon }} </i>
</template>
<style>
    
</style>
<script>
    export default{
        props: ['status'],
        data(){
            return{
                msg:'hello vue'
            }
        },
        computed: {
            icon() {
                let icon = 'schedule';
                if(this.status=='released') icon = 'done';
                if(this.status=='in progress') icon = 'loop';
                return icon;
            }
        }
    }
</script>
