<template>
    <div class="center-align feature-form-area">
        <h2 class="feature-req-title" v-text="lang.title_text.product_list">Products list of ThemeXpert</h2>
        <!-- Modal Trigger -->
        <a class="waves-effect waves-light btn red mb15" href="#modal1"><i class="material-icons left">add</i> <span v-text="lang.button.add_product">Add new Product</span></a>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 class="modal-title" v-text="lang.modal.new_product.title">Add new product</h4>
                <form class="" action="" @submit.prevent="saveNewProduct">
                    <div class="row">
                        <div class="input-field">
                            <input name="name" v-model="product.name" id="product_name" type="text" :placeholder="lang.modal.new_product.product.placeholder">
                            <label for="product_name" v-text="lang.modal.new_product.product.title">Product Name</label>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea name="description" v-model="product.description" id="textarea1" class="materialize-textarea" :placeholder="lang.modal.new_product.description.placeholder"></textarea>
                        <label for="textarea1" v-text="lang.modal.new_product.description.label">Add details</label>
                    </div>
                    <!--<div class="input-field">-->
                        <!--<input name="logo" type="file" @change="fileSelected" placeholder="Product Logo">-->
                    <!--</div>-->
                    <div class="input-field left-align">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right" v-text="lang.button.close">Close</a>
                        <button type="submit" class="btn" :disabled="busy"><span v-text="lang.modal.new_product.btn_product">Save Product</span> <i class="material-icons left">done</i> <spinner v-if="busy"></spinner></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../config/Hunt'
    export default{
        data(){
            return{
                product: {
                    name: '',
                    description: '',
                    file: null
                },
                busy: false
            }
        },
        mounted() {
            $(".modal").modal({dismissible:false});
        },
        methods: {
            /**
             * Listens to file change event
             */
            fileSelected (e) {
                this.product.file = e.target.value;
            },
            /**
             * Validates input
             */
            validateInputs() {
                let valid = true;

                if(this.product.name=='') {
                    Hunt.toast('Product name can not be empty.', 'warning');
                    valid = false;
                }

                if(this.product.description=='') {
                    Hunt.toast('Product description can not be empty.', 'warning');
                    valid = false;
                }

//                if(this.product.file==null) {
//                    Hunt.toast('Please select a logo.', 'warning');
//                    valid = false;
//                }

                return valid;
            },
            /**
             * Save a new product
             *
             * @param e
             * @returns {boolean}
             */
            saveNewProduct(e) {
                let data = new FormData(e.target);
                if(!this.validateInputs()) return false;
                this.busy=true;
                this.post('/products', data).then(
                    success => {
                        this.$store.commit('new_product_added', success.body.product);
                        Hunt.toast('New product have been saved.', 'success');
                        this.busy = false;
                        this.product.name = '';
                        this.product.description='';
                        $("#modal1").modal('close');
                    },
                    fail => {
                        if(fail.status==422) {
                            Hunt.toast('Please fill out all fields correctly.', 'error');
                        }
                        this.busy=false;
                        console.log(fail);
                    }
                );
            }
        }
    }
</script>
