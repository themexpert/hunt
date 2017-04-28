<template>
        <!-- Modal Structure -->
        <div id="modal-edit-feature-request" class="modal">
            <div class="modal-content">
                <h4 class="modal-title" v-text="lang.modal.edit_feature_request.title">Suggest a feature for ThemeXpert</h4>
                <div class="">
                    <div class="row">
                        <div class="input-field">
                            <input v-model="n_feature.name" id="suggest_feature" type="text" :placeholder="lang.modal.edit_feature_request.feature.placeholder">
                            <label for="suggest_feature" v-text="lang.modal.edit_feature_request.feature.label">Suggest a feature</label>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea v-model="n_feature.description" id="textarea1" class="materialize-textarea" :placeholder="lang.modal.edit_feature_request.details.placeholder"></textarea>
                        <label for="textarea1" v-text="lang.modal.edit_feature_request.details.label">Add details (if you need to)</label>
                    </div>
                    <div v-if="isAdmin" class="row">
                        <div class="input-field">
                            <select2 v-model="n_feature.tags" :tags="true" :placeholder="lang.placeholder.dropdown.tag">
                                <option v-for="tag in tags" :value="tag.label">{{ tag.label.toUpperCase() }}</option>
                            </select2>
                        </div>
                    </div>
                    <div class="input-field left-align">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right" v-text="lang.button.close">Close</a>
                        <button @click="updateFeatureRequest" class="btn" :disabled="busy"><span v-text="lang.modal.edit_feature_request.btn_suggest">Tell ThemeXpert I want this</span> <i class="material-icons left">done</i> <spinner v-if="busy"></spinner></button>
                    </div>
                </div>
            </div>
        </div>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../../../config/Hunt'
    import products from '././../../products.vue'
    export default{
        props: ['feature'],
        components: {
            'products': products
        },
        data(){
            return{
                n_feature: {
                    access: false,
                    tags: [],
                    name: '',
                    description: ''
                },
                busy: false,
                reloadTags: true,
                modal: null
            }
        },
        mounted() {
            this.modal = $("#modal-edit-feature-request");
            this.modal.modal({dismissible:false,complete: ()=>{this.$emit('closed', null)}});
            this.modal.modal('open');
            this.n_feature.tags = this.feature.tags;
            this.n_feature.name = this.feature.name;
            this.n_feature.description = this.feature.description;
            Vue.nextTick(()=>{Materialize.updateTextFields();});
        },
        methods: {
            /**
             * Prepares data to be sent
             */
            prepareData() {
                let data = {
                    name: this.n_feature.name,
                    description: this.n_feature.description,
                    is_private: this.n_feature.access !== "false",
                    tags: this.n_feature.tags
                };
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
                return valid;
            },
            /**
             * Send the feature request
             */
            updateFeatureRequest() {
                let data = this.prepareData();
                if(!this.validateInputs(data)) return false;
                this.busy=true;
                this.post('/products/'+this.feature.product_id+'/features/'+this.feature.id, data).then(
                    success => {
                        Hunt.toast('Your feature request has been received.', 'success');
                        this.modal.modal('close');
                        if(this.reloadTags) this.$store.commit('update_tags');
                        this.busy = false;
                        this.$store.commit('feature_updated', Object.assign({id: this.feature.id}, this.n_feature));
                        Bus.$emit("feature-updated", this.n_feature);
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
