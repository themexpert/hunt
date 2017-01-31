<template>
    <td>
        <div class="progress tooltipped" :data-tooltip="progress">
            <div class="determinate" :style="{width: progress}"></div>
        </div>
    </td>
</template>
<script>
    export default{
        name: 'FeatureEffortValue',
        props: ['priority'],
        data(){
            return{
            }
        },
        mounted() {
            /**
             * Initiate tooltip for sub-component
             */
            $("[data-tooltip]").tooltip();
        },
        computed: {
            /**
             * Gives the priority value in percentage
             *
             * @returns {*}
             */
            progress() {
                if(this.priority==null) return '0%';
                return this.priority.value + '%';
            }
        }
    }
</script>
