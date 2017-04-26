<template>
    <li class="collection-item avatar">
        <router-link :to="productUrl"><h4 class="title">{{ product.name }}</h4></router-link>
        <div class="description">{{ product.description }}</div>
        <div class="secondary-content product-action">
            <button class="btn waves-effect waves-light btn teal amber darken-4 right" @click="deleteProduct">DELETE</button>
            <button class="btn waves-effect waves-light btn teal right" @click="editProduct">EDIT</button>
        </div>
        <confirm v-if="showDeleteModal" :item="product.id" message="Are you sure you want to delete this product?" @confirm="confirmed"></confirm>
        <edit-product v-if="showEditModal" :product="product" @closed="edit_closed"></edit-product>
    </li>
</template>
<style>
    .product-action button {
        margin-left: 5px;
    }
</style>
<script type="text/babel">
    import confirm_modal from './components/confirm.vue'
    import edit_product from './components/edit-product-modal.vue'
    import Hunt from './../../../config/Hunt'
    export default{
        name: 'ProductItem',
        props: ['product'],
        components: {
            'confirm': confirm_modal,
            'edit-product': edit_product
        },
        data(){
            return {
                showDeleteModal: false,
                showEditModal: false
            }
        },
        methods: {
            editProduct() {
                this.showEditModal = true;
            },
            edit_closed() {
                this.showEditModal = false;
            },
            deleteProduct() {
                this.showDeleteModal = true;
            },
            confirmed(d) {
                const that = this;
                setTimeout(()=>{
                    that.showDeleteModal = false;
                }, 300);
                if(!d) return;
                this.$http.delete('/api/products/'+this.product.id)
                    .then(response=>{
                        this.$store.commit('product_deleted', this.product);
                        Hunt.toast(response.data.message, "success");
                    }).catch(error=>{
                        Hunt.toast("Something went wrong.", "error");
                        console.log(error);
                });
            }
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
