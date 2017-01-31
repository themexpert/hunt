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
            $("[data-tooltip]").tooltip();
        },
        computed: {
            progress() {
                if(this.priority==null) return '0%';
                return this.priority.value + '%';
            }
        }
    }
</script>
