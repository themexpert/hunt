<template>
    <div class="center-align feature-form-area">
        <h2 class="feature-req-title" v-text="lang.title_text.features">Feature requests for ThemeXpert</h2>
        <!-- Modal Trigger -->
        <a class="waves-effect waves-light btn red mb15" href="#modal1"><i class="material-icons left">add</i> Suggest a feature</a>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4 class="modal-title" v-text="lang.modal.feature_request.title">Suggest a feature for ThemeXpert</h4>
                <div class="">
                    <div class="row">
                        <div class="input-field col s6">
                            <input v-model="feature.name" id="suggest_feature" type="text" :placeholder="lang.modal.feature_request.feature.placeholder">
                            <label for="suggest_feature" v-text="lang.modal.feature_request.feature.label">Suggest a feature</label>
                        </div>
                        <div class="input-field col s6">
                            <products v-model="feature.product_id"></products>
                        </div>
                    </div><!--/.row-->
                    <div class="input-field">
                        <textarea v-model="feature.description" id="textarea1" class="materialize-textarea" :placeholder="lang.modal.feature_request.details.placeholder"></textarea>
                        <label for="textarea1" v-text="lang.modal.feature_request.details.label">Add details (if you need to)</label>
                    </div>
                    <div class="row">
                        <!--<div class="input-field col s6">-->
                            <!--<select2 v-model="feature.access">-->
                                <!--<option v-for="access in feature.accesses" :value="access.value">{{ access.label }}</option>-->
                            <!--</select2>-->
                        <!--</div>-->
                        <div class="input-field col s12">
                            <select2 v-model="feature.tags" :tags="true">
                                <option v-for="tag in tags" :value="tag.label">{{ tag.label.toUpperCase() }}</option>
                            </select2>
                        </div>
                    </div>
                    <div class="input-field left-align">
                        <button @click="submitFeatureRequest" class="btn" :disabled="busy"><span v-text="lang.modal.feature_request.btn_suggest">Tell ThemeXpert I want this</span> <i class="material-icons left">done</i> <spinner v-if="busy"></spinner></button>
                    </div>
                </div>
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
                    access: false,
                    tags: [],
                    name: '',
                    product_id: null,
                    description: ''
                },
                busy: false,
                reloadTags: true
            }
        },
        methods: {
            /**
             * Prepares data to be sent
             */
            prepareData() {
                let data = {
                    name: this.feature.name,
                    description: this.feature.description,
                    is_private: this.feature.access !== "false",
                    tags: this.feature.tags
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
            submitFeatureRequest() {
                let data = this.prepareData();
                if(!this.validateInputs(data)) return false;
                this.busy=true;
                this.post('/products/'+this.feature.product_id+'/features', data).then(
                    success => {
                        Hunt.toast('Your feature request has been received.', 'success');
                        $("#modal1").modal('close');
                        if(this.reloadTags) this.$store.commit('update_tags');
                        this.$router.push('/products/'+this.feature.product_id+'/features/'+success.body.feature.id+'?set_priority=true');
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
