<template>
    <tr>
        <value :value="feature.value"></value>
        <feature :feature="feature"></feature>
        <status :status="feature.status"></status>
    </tr>
</template>
<style>
    
</style>
<script>
    import Feature from './components/feature.vue'
    import Status from './components/status.vue'
    import Value from './components/value.vue'
    export default{
        name: 'FeatureItem',
        props: ['feature'],
        components: {
            'feature': Feature,
            'status': Status,
            'value': Value
        },
        data(){
            return{
            }
        }
    }
</script>
