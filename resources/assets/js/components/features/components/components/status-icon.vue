<template>
    <i class="material-icons circle" data-position="top" :data-tooltip="icon.tooltip"> {{ icon.icon }} </i>
</template>
<style>
    
</style>
<script>
    export default{
        props: ['status'],
        data(){
            return{
            }
        },
        mounted() {
            $("i[data-tooltip]").tooltip();
        },
        computed: {
            /**
             * Gives the correct icon for feature status type
             * @returns {*}
             */
            icon() {
                if (this.status === null || this.status === "PENDING")
                    return {
                        icon: 'schedule',
                        tooltip: 'Pending'
                    };
                if (this.status === 'RELEASED')
                    return {
                        icon: 'done',
                        tooltip: 'Released'
                    };
                if (this.status === 'WIP')
                    return {
                        icon: 'loop',
                        tooltip: 'Work In Progress'
                    };
                if (this.status === 'DECLINED')
                    return {
                        icon: 'block',
                        tooltip: 'Declined'
                    };
            }
        }
    }
</script>
