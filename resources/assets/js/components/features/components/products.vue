<template>
    <select id="product_select">
        <option :value="null" disabled>Select Products</option>
        <option v-for="(name, key) in products" :value="key">{{ name }}</option>
    </select>
</template>
<style>
    
</style>
<script type="text/babel">
    export default {
        data(){
            return {
                product: null
            }
        },
        mounted() {
            this.product = this.products.length>0?0:null;
            let that = this;
            $("#product_select").change(e => {
                that.product = $("#product_select").val();
            });
        },
        methods: {

        },
        computed: {
            products() {
                return this.$store.state.features.products;
            }
        },
        watch: {
            product() {
                this.$store.dispatch('product_changed', this.product);
            }
        }
    }
</script>
