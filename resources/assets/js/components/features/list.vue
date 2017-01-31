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
                                    <filters :filter="$route.params.filter || ''"></filters>
                                </div>
                            </div>
                            <div class="col s3">
                                <div class="input-field">
                                    <products :update="true"></products>
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
                        <feature-list-item v-for="feature in features" :item="feature"></feature-list-item>
                        <li v-if="features.length==0" class="text-center">No feature request found.</li>
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
    import preloader_2 from '../preloader-2.vue'
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
                loading: true
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
                        product_id: this.$route.params.product_id,
                        filter:this.$route.params.filter
                    });
            /**
             * Register infinite scroll
             */
            Hunt.infiniteScroll('/products', ()=>{
                this.loading = true;
                this.$store.commit('update_features', true);
            });
            /**
             * Register feature list loaded listener
             *
             * @type {boolean}
             */
            Bus.$on('feature-list-loaded', ()=>{this.loading=false;});
        },
        computed: {
            /**
             * Loaded features list in the store
             *
             * @returns {computed.features|*|Array}
             */
            features() {
                return this.$store.state.features.features;
            }
        }
    }
</script>
