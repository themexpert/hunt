<template>
    <section class="main-content">
        <div class="banner blue darken-2">
            <div class="container">
                <div class="feature-req">
                    <feature-request-modal></feature-request-modal>

                    <div class="feature-filter">
                        <div class="row">
                            <div class="col s9">
                                <div class="progress-link">
                                    <filters></filters>
                                </div>
                            </div>
                            <div class="col s3">
                                <div class="input-field">
                                    <products v-model="product_id">
                                        <option value="all">All</option>
                                    </products>
                                </div>
                            </div>
                        </div><!--/.row-->
                    </div><!--/.feature-list-->
                </div><!--/.feature-req-->
            </div><!--/.container-->
        </div><!--/.banner-->

        <div class="container">
            <div class="feature-list card">
                <div class="details">
                    <ul class="collection feature-list">
                        <template v-if="!loading">
                            <feature-list-item v-for="feature in features" :feature="feature"></feature-list-item>
                            <li v-if="features.length==0" class="text-center" v-text="lang.no_result_message.feature_requests">No feature request found.</li>
                        </template>
                        <li style="text-align: center" v-if="loading"><preloader-2></preloader-2></li>
                    </ul><!--/.card-->
                </div><!--/.details-->
            </div><!--/.feature-req-->
        </div>
    </section>
</template>
<script>
    import Hunt from '../../config/Hunt'
    import filters from './components/filters.vue'
    import products from './components/products.vue'
    import featureRequestModal from './components/feature-request-modal.vue'
    import featureListItem from './components/list-item.vue'
    import preloader_2 from '../helpers/preloader-2.vue'
    export default{
        components: {
            'filters': filters,
            'products': products,
            'feature-request-modal': featureRequestModal,
            'feature-list-item': featureListItem,
            'preloader-2': preloader_2
        },
        data(){
            return {
                loading: false,
                product_id: null,
                product_id_old: null
            }
        },
        mounted() {
            Hunt.renderPage('Feature Requests');
            /**
             * Initiate first load
             */
            if(this.$route.params.query)
                this.$store.dispatch('search_features', this.$route.params.query);
            if(this.$route.params.filter)
                this.$store.dispatch('apply_filter',
                    {
                        product_id: this.product_id,
                        filter:this.$route.params.filter
                    });
            /**
             * Register infinite scroll
             */
            Hunt.infiniteScroll('.feature-list', ()=>{
                if(!this.$store.state.features.features.length) return;
                this.loading = true;
                this.$store.commit('update_features', true);
            });
            /**
             * Register feature list loaded listener
             *
             * @type {boolean}
             */
            Bus.$on('feature-list-loaded', ()=>{this.loading=false;});
            Bus.$on('products_loaded', ()=>{
                if(this.products.length>0)
                    this.load(); //if we have products then set one
            }); //invoke first time load when products are loaded
            //don't run into error when the products are not loaded
            if(this.products.length>0)
                this.load(); //if we have products then set one
        },
        methods: {
            load() {
                this.loading = true;
                this.product_id = this.$route.params.product_id;
                if(this.product_id===undefined && this.products.length>0) {
                    this.product_id = 'all';//this.$store.state.features.product_id || this.products[0].id;
                    this.$router.push('/products/all/features');
                }
                this.$store.dispatch('product_changed', this.product_id);
                this.product_id_old = this.product_id;
            }
        },
        computed: {

            /**
             * Products list from store
             *
             * @returns {computed.products|Array|*}
             */
            products() {
                return this.$store.state.features.products;
            },

            /**
             * Loaded features list in the store
             *
             * @returns {computed.features|*|Array}
             */
            features() {
                return this.$store.state.features.features;
            }
        },
        watch: {
            product_id() {
                if(this.product_id===this.product_id_old) return;
                this.$router.push('/products/'+this.product_id+'/features');
                this.$store.dispatch('product_changed', this.product_id);
            }
        }
    }
</script>
