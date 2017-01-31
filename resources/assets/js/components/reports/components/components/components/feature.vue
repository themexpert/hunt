<template>
    <td>
        <h4 class="title"><router-link :to="productUrl">{{ feature.product.name }}</router-link>: <router-link to="featureUrl">{{ feature.name }}</router-link></h4>
        <p>{{ feature.description }}</p>
    </td>
</template>
<style>
    
</style>
<script>
    export default{
        name: 'ReportsFeatureItem',
        props: ['feature'],
        data(){
            return{
                msg:'hello vue'
            }
        },
        computed: {
            productUrl() {
                return '/products/'+this.feature.product_id+'/features';
            },
            featureUrl() {
                return '/products/'+this.feature.product_id+'/features/'+this.feature.id;
            }
        }
    }
</script>
