<template>
    <select2 v-model="product_id">
        <option v-for="product in products" :value="product.id">{{ product.name }}</option>
    </select2>
</template>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    export default {
        name: "ProductsDropdown",
        props: ['value'],
        data(){
            return {
                product: null,
                product_id: null
            }
        },
        mounted() {
            this.product_id = this.value;
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
        },
        watch: {
            product_id() {
                this.$emit('input', this.product_id);
            },
            value() {
                this.product_id = this.value;
            }
        }
    }
</script>
