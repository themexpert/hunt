<template>
    <td><span class="chip green">{{ status.type }}</span></td>
</template>
<script>
    export default{
        name: 'ReportsFeatureStatus',
        props: ['status'],
        data(){
            return{
            }
        }
    }
</script>
