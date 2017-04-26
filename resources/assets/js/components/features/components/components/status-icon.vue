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
                        tooltip: this.lang.tooltip.status.pending
                    };
                if (this.status === 'RELEASED')
                    return {
                        icon: 'done',
                        tooltip: this.lang.tooltip.status.released
                    };
                if (this.status === 'WIP')
                    return {
                        icon: 'loop',
                        tooltip: this.lang.tooltip.status.wip
                    };
                if (this.status === 'DECLINED')
                    return {
                        icon: 'block',
                        tooltip: this.lang.tooltip.status.declined
                    };
            }
        },
        watch: {
            lang() {
                Vue.nextTick(()=>{
                    const tooltip = $("i[data-tooltip]");
                    tooltip.tooltip('remove');
                    tooltip.tooltip();
                });
            }
        }
    }
</script>
