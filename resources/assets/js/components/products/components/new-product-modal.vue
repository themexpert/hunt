<template>
    <div class="center-align feature-form-area">
        <h2 class="feature-req-title">Products list of ThemeXpert</h2>
        <!-- Modal Trigger -->
        <a class="waves-effect waves-light btn red mb15" href="#modal1"><i class="material-icons left">add</i> Add new Product</a>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 class="modal-title">Add new product</h4>
                <form class="" action="" @submit.prevent="saveNewProduct">
                    <div class="row">
                        <div class="input-field col s6">
                            <input name="name" v-model="product.name" id="product_name" type="text" placeholder="Product Name">
                            <label for="product_name">Product Name</label>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea name="description" v-model="product.description" id="textarea1" class="materialize-textarea" placeholder="Please keep this as details as possible ..."></textarea>
                        <label for="textarea1">Add details</label>
                    </div>
                    <div class="input-field">
                        <input name="logo" type="file" @change="fileSelected" placeholder="Product Logo">
                    </div>
                    <div class="input-field left-align">
                        <button type="submit" class="btn" :disabled="busy">Save Product <i class="material-icons left">done</i> <spinner v-if="busy"></spinner></button>
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
            $(".modal").modal();
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

                if(this.product.file==null) {
                    Hunt.toast('Please select a logo.', 'warning');
                    valid = false;
                }

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
                        Bus.$emit('new-product-saved', success.body.product);
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
