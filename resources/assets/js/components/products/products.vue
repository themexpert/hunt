<template>
    <section class="main-content">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
                    <new-product-modal></new-product-modal>
                </div><!--/.feature-req-->
            </div><!--/.container-->
        </div><!--/.banner-->

        <div class="container">
            <div class="feature-list card">
                <div class="details">
                    <ul class="collection products-list">
                        <product-item v-for="product in products" :product="product"></product-item>
                        <li v-if="products.length==0" class="text-center">No product found.</li>
                        <li v-if="loading"><preloader-2></preloader-2></li>
                    </ul><!--/.card-->
                </div><!--/.details-->
            </div><!--/.feature-req-->
        </div>
    </section>
</template>
<style>
    
</style>
<script type="text/babel">
    import Hunt from '../../config/Hunt'
    import newProductModal from './components/new-product-modal.vue'
    import productItem from './components/product-item.vue'
    export default{
        name: 'Products',
        components: {
            'new-product-modal': newProductModal,
            'product-item': productItem
        },
        data(){
            return{
            }
        },
        mounted() {
            /**
             * Check for admin access
             */
            if(!this.isAdmin) {
                Hunt.toast('You can not access this route.', 'info');
                this.$router.push('/');
                return;
            }
            Hunt.renderPage('Products');
            /**
             * Register new product saved listener
             */
            Bus.$on('new-product-saved', product=>{
                this.$store.state.features.products.unshift(product);
            });
        },
        methods: {

        },
        computed: {
            /**
             * Gived products list from store
             *
             * @returns {computed.products|products|{index}|Array|*}
             */
            products() {
                return this.$store.state.features.products;
            }
        }
    }
</script>
