<template>
    <li class="collection-item">
        <router-link :to="productUrl"><h4 class="title">{{ product.name }}</h4></router-link>
        <div class="description">{{ product.description }}</div>
    </li>
</template>
<style>

</style>
<script type="text/babel">
    export default{
        name: 'ProductItem',
        props: ['product'],
        data(){
            return {}
        },
        computed: {
            /**
             * Gives product route
             */
            productUrl(){
                return '/products/' + this.product.id + '/features/';
            }
        }
    }
</script>
