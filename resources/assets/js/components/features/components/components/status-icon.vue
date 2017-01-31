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
            /**
             * Gives the correct icon for feature status type
             * @returns {*}
             */
            icon() {
                if (this.status == null || this.status == "PENDING") return 'schedule';
                if (this.status == 'RELEASED') return 'done';
                if (this.status == 'WIP') return 'loop';
                if (this.status == 'DECLINED') return 'block';
            }
        }
    }
</script>
