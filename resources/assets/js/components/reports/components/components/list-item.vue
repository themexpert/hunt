<template>
    <tr>
        <priority :priority="feature.priority"></priority>
        <feature :feature="feature"></feature>
        <status :status="feature.status"></status>
    </tr>
</template>
<style>
    
</style>
<script>
    import Feature from './components/feature.vue'
    import Status from './components/status.vue'
    import Priority from './components/priority.vue'
    export default{
        name: 'FeatureItem',
        props: ['feature'],
        components: {
            'feature': Feature,
            'status': Status,
            'priority': Priority
        },
        data(){
            return{
            }
        }
    }
</script>
