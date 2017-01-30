<template>
    <multiselect
            :options="products"
            :value="product"
            v-model="product"
            @input="updateProduct"
            track-by="name"
            label="name"
            placeholder="Select a product">
    </multiselect>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    export default {
        props: ['selected', 'update', 'input'],
        data(){
            return {
                product: null
            }
        },
        mounted() {
            Bus.$on('products_loaded', this.load); //invoke first time load when products are loaded
            //don't run into error when the products are not loaded
            if(this.products.length>0) this.load(); //if we have products then set one
        },
        methods: {
            load() {
                if(this.products.length==0 || this.update==undefined || this.update==false) return; //no product found or just showing the dropdown
                let product_id = this.$route.params.product_id || this.$store.state.features.product_id;
                if(product_id==undefined) {
                    product_id = this.products[0].id;
                    this.$router.push('/products/'+product_id+'/features'+'/'+this.$store.state.features.filter);
                }
                this.$store.dispatch('product_changed', product_id);
                this.products.forEach(x=>{
                    if(x.id==product_id) this.product = x;
                });
            },
            /**
             * Updates the product in store and invokes product_changed
             * @param nP
             */
            updateProduct(nP) {
                if(this.input!=undefined) this.input(nP);
                if(this.update!=undefined && this.update==true && nP!=null) {
                    this.$router.push('/products/'+nP.id+'/features');
                    this.$store.dispatch('product_changed', nP.id);
                }
            }
        },
        computed: {
            /**
             * Products list from store
             *
             * @returns {computed.products|Array|*}
             */
            products() {
                return this.$store.state.features.products;
            }
        }
    }
</script>
