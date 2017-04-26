<template>
        <!-- Modal Structure -->
        <div id="modal" class="modal modal-product-edit">
            <div class="modal-content">
                <h4 class="modal-title" v-text="lang.modal.edit_product.title">Update Product</h4>
                <form class="" action="" @submit.prevent="updateProduct">
                    <div class="row">
                        <div class="input-field">
                            <input name="name" v-model="n_product.name" id="product_name" type="text" :placeholder="lang.modal.edit_product.product.placeholder">
                            <label for="product_name" v-text="lang.modal.edit_product.product.title">Product Name</label>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea name="description" v-model="n_product.description" id="textarea1" class="materialize-textarea" :placeholder="lang.modal.edit_product.description.placeholder"></textarea>
                        <label for="textarea1" v-text="lang.modal.edit_product.description.label">Add details</label>
                    </div>
                    <!--<div class="input-field">-->
                    <!--<input name="logo" type="file" @change="fileSelected" placeholder="Product Logo">-->
                    <!--</div>-->
                    <div class="input-field left-align">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right" v-text="lang.button.close">Close</a>
                        <button type="submit" class="btn" :disabled="busy"><span v-text="lang.modal.edit_product.btn_product">Update Product</span> <i class="material-icons left">done</i> <spinner v-if="busy"></spinner></button>
                    </div>
                </form>
            </div>
        </div>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../../config/Hunt'
    export default{
        props: ['product'],
        data(){
            return{
                n_product: {
                    name: '',
                    description: ''
                },
                modal: null,
                busy: false
            }
        },
        mounted() {
            this.n_product = {
                name: this.product.name,
                description: this.product.description
            };
            this.modal = $(".modal-product-edit");
            this.modal.modal({dismissible:false,complete: ()=>{this.$emit('closed', null)}});
            this.modal.modal('open');
            Vue.nextTick(()=>{Materialize.updateTextFields();});
        },
        methods: {
            /**
             * Validates input
             */
            validateInputs() {
                let valid = true;
                if(this.n_product.name==='') {
                    Hunt.toast('Product name can not be empty.', 'warning');
                    valid = false;
                }
                if(this.n_product.description==='') {
                    Hunt.toast('Product description can not be empty.', 'warning');
                    valid = false;
                }
                return valid;
            },
            /**
             * Update product
             *
             * @param e
             * @returns {boolean}
             */
            updateProduct(e) {
                let data = new FormData(e.target);
                if(!this.validateInputs()) return false;
                this.busy=true;
                this.post('/products/'+this.product.id, data).then(
                    success => {
                        this.$store.commit('product_updated', Object.assign(this.n_product, {id: this.product.id}));
                        Hunt.toast('Product has been updated.', 'success');
                        this.busy = false;
                        this.modal.modal('close');
                    },
                    fail => {
                        if(fail.status==422) {
                            Hunt.toast('Please fill out all fields correctly.', 'error');
                        }
                        else {
                            Hunt.toast('Something went wrong. Could not update product.', 'error');
                        }
                        this.busy=false;
                        console.log(fail);
                    }
                );
            }
        }
    }
</script>
