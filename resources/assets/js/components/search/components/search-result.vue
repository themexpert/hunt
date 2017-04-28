<template>
    <li class="collection-item">
        <div class="chip grey darken-1">
            <strong>
                <router-link :to="productUrl" style="color: #fff3e0;">{{ result.product.name }}</router-link>
            </strong>
        </div>
        <p>
            <router-link :to="featureUrl">{{ result.name }}</router-link>
        </p>
    </li>
</template>
<style>
    .search-results .collection-item {
        border-bottom: 1px solid #222222;
    }
    .search-results .collection-item:last-child {
        border-bottom: none;
    }
    .search-results .collection-item, .collection-item p {
        padding: 5px;
        margin: 0;
    }
    .search-results .collection-item p a {
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
