<template>
    <div class="center-align feature-form-area">
        <h2 class="feature-req-title">Feature requests for ThemeXpert</h2>
        <!-- Modal Trigger -->
        <a class="waves-effect waves-light btn red" href="#modal1"><i class="material-icons left">add</i> Suggest a feature</a>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 class="modal-title">Suggest a feature for ThemeXpert</h4>
                <form class="" action="" @submit.prevent="submitFeatureRequest">
                    <div class="row">
                        <div class="input-field col s6">
                            <input v-model="feature.name" id="suggest_feature" type="text" placeholder="What do you have in mind ?">
                            <label for="suggest_feature">Suggest a feature</label>
                        </div>
                        <div class="input-field col s6">
                            <products :selected="selected_product" :input="updateProduct"></products>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea v-model="feature.description" id="textarea1" class="materialize-textarea" placeholder="Please keep this as details as possible ..."></textarea>
                        <label for="textarea1">Add details (if you need to)</label>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <multiselect id="access"
                                         :options="feature.accesses"
                                         :value="feature.access"
                                         v-model="feature.access"
                                         track-by="label"
                                         label="label"
                                         placeholder="Select Access"></multiselect>
                        </div>
                        <div class="input-field col s6">
                            <multiselect
                                    :options="tags"
                                    :value="feature.tags"
                                    v-model="feature.tags"
                                    track-by="label"
                                    label="label"
                                    :multiple="true"
                                    placeholder="Select Tags"></multiselect>
                        </div>
                    </div>
                    <div class="input-field left-align">
                        <button type="submit" class="btn" :disabled="busy">Tell ThemeXpert I want this <i class="material-icons left">done</i> </button>
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
    import products from './products.vue'
    export default{
        components: {
            'products': products
        },
        data(){
            return{
                feature: {
                    accesses: [
                        {
                            label: 'Private',
                            value: true
                        },
                        {
                            label: 'Public',
                            value: false
                        }
                    ],
                    access: null,
                    tags: null,
                    name: '',
                    product_id: null,
                    description: ''
                },
                selected_product: null,
                busy: false
            }
        },
        methods: {
            /**
             * Listens to product select and updates product
             */
            updateProduct(nP) {
                if(nP==null) {
                    this.feature.product_id=null;
                    return;
                }
                this.feature.product_id=nP.id;
            },
            /**
             * Prepares data to be sent
             */
            prepareData() {
                let data = {
                    name: this.feature.name,
                    description: this.feature.description,
                    is_private: this.feature.access!=null?this.feature.access.value:null,
                    tags: []
                };
                if(this.feature.tags==null)
                    data.tags = [];
                else
                    this.feature.tags.forEach(x=>{
                        data.tags.push(x.label);
                    });
                return data;
            },
            /**
             * Validates inputs
             *
             * @param data
             */
            validateInputs(data) {
                let valid = true;

                if(this.feature.product_id==null) {
                    Hunt.toast('Please select a product.', 'warning');
                    valid = false;
                }

                if(data.name=='' || data.name==null) {
                    Hunt.toast('Feature name can not be empty.', 'warning');
                    valid = false;
                }

                if(data.description=='' || data.description==null) {
                    Hunt.toast('Details can not be empty.', 'warning');
                    valid = false;
                }

                if(data.is_private==null) {
                    Hunt.toast('Please select access.', 'warning');
                    valid = false;
                }

                if(data.tags.length==0) {
                    Hunt.toast('Please select a tag.', 'warning');
                    valid = false;
                }
                return valid;
            },
            /**
             * Send the feature request
             */
            submitFeatureRequest() {
                let data = this.prepareData();
                if(!this.validateInputs(data)) return false;
                this.busy=true;
                this.post('/products/'+this.feature.product_id+'/features', data).then(
                    success => {
                        Hunt.toast('Your feature request has been received.', 'success');
                        this.busy = false;
                        if(this.$store.state.features.product_id==this.feature.product_id) {
                            this.$store.state.features.features.unshift({
                                is_public: !data.is_private,
                                id: success.body.id,
                                description: data.description,
                                name: data.name,
                                product_id: this.feature.product_id,
                                status: {type: 'PENDING'},
                                tags: data.tags.map(x=>{
                                    return {name: x}
                                })
                            });
                        }
                        this.feature.name = '';
                        this.feature.description='';
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
        },
        computed: {
            /**
             * Gives tags list loaded from store\
             *
             * @returns {null|Array|*|computed.tags}
             */
            tags() {
                return this.$store.state.features.tags;
            }
        }
    }
</script>
