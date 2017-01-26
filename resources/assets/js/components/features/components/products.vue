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
        props: ['selected', 'update'],
        data(){
            return {
                product: null
            }
        },
        mounted() {
        },
        methods: {
            updateProduct(nP) {
                if(this.update!=undefined && this.update==true && nP.id!=undefined)
                    this.$store.dispatch('product_changed', nP.id);
            }
        },
        computed: {
            products() {
                return this.$store.state.features.products;
            }
        },
        watch: {
            products() {
                if (typeof this.selected == "undefined") {
                    this.product = this.products.length > 0 ? this.products[0] : null;
                    this.$store.dispatch('product_changed', this.product.id);
                }
            }
        }
    }
</script>
