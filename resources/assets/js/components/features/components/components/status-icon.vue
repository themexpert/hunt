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
                if (this.status == null || this.status == "PENDING") return 'schedule';
                if (this.status == 'RELEASED') return 'done';
                if (this.status == 'WIP') return 'loop';
                if (this.status == 'DECLINED') return 'block';
            }
        }
    }
</script>
