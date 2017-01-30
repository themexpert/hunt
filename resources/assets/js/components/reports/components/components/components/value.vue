<template>
    <td>
        <div class="progress tooltipped" :data-tooltip="toolTipValue">
            <div class="determinate" :style="styleValue"></div>
        </div>
    </td>
</template>
<script>
    export default{
        name: 'FeatureEffortValue',
        props: ['value'],
        data(){
            return{
            }
        },
        computed: {
            toolTipValue() {
                return this.value + '%';
            },
            styleValue() {
                return "width: " + this.value+ "%;";
            }
        }
    }
</script>
