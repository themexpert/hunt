<template>
    <li class="collection-item">
        <p><strong><router-link :to="productUrl">{{ result.product.name }}</router-link></strong><router-link :to="featureUrl">{{ result.name }}</router-link></p>
    </li>
</template>
<style>
    .collection-item {
        width: 100%;
    }
    .collection-item, .collection-item p {
        padding: 0;
    }
    .collection-item p a {
        color: #8740ac;
    }
</style>
<script>
    export default{
        name: 'SearchResult',
        props: ['result'],
        data(){
            return{
            }
        },
        computed: {
            /**
             * Gives the product page route
             *
             * @returns {string}
             */
            productUrl() {
                return '/products/'+this.result.product_id+'/features';
            },
            /**
             * Gives the feature page route
             *
             * @returns {string}
             */
            featureUrl() {
                return '/products/'+this.result.product_id+'/features/'+this.result.id;
            }
        }
    }
</script>
