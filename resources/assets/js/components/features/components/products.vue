<template>
    <select2
            :selected-value="selectedValue"
            :options="productsForSelect2"
            :update="updateProduct"></select2>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    export default {
        props: ['selected', 'update', 'input'],
        data(){
            return {
                product: null,
                selectedValue: null
            }
        },
        mounted() {
            Bus.$on('products_loaded', this.load); //invoke first time load when products are loaded
            //don't run into error when the products are not loaded
            if(this.products.length>0) this.load(); //if we have products then set one
        },
        methods: {
            /**
             * Populates the features page components information
             */
            load() {
                if(this.products.length==0 || this.update==undefined || this.update==false) return; //no product found or just showing the dropdown
                let product_id = this.$route.params.product_id;
                if(product_id==undefined) {
                    product_id = this.$store.state.features.product_id || this.products[0].id;
                    this.$router.push('/products/'+product_id+'/features'+'/'+this.$store.state.features.filter);
                }
                this.selectedValue = product_id;
                this.$store.dispatch('product_changed', product_id);
                this.products.forEach(x=>{
                    if(x.id==product_id) this.product = x;
                });
            },
            /**
             * Updates the product in store and invokes product_changed
             * @param value
             */
            updateProduct(value) {
                if(this.input!=undefined) this.input(value);
                if(this.update!=undefined && this.update==true && value!=null) {
                    this.$router.push('/products/'+value+'/features');
                    this.$store.dispatch('product_changed', value);
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
            },
            productsForSelect2() {
                let products = [];
                for(let i=0;i<this.products.length;i++) {
                    let x = this.products[i];
                    products.push({
                        id: x.id,
                        text: x.name
                    });
                }
                return products;
            }
        }
    }
</script>
