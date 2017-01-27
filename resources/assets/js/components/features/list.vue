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
                    <ul class="collection">
                        <feature v-for="feature in features" :item="feature"></feature>
                    </ul><!--/.card-->
                </div><!--/.details-->
            </div><!--/.feature-req-->
        </div>
    </section>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../config/Hunt'
    import filters from './components/filters.vue'
    import products from './components/products.vue'
    import featureRequestModal from './components/feature-request-modal.vue'
    import feature from './components/list-item.vue'
    export default{
        components: {
            'filters': filters,
            'products': products,
            'feature-request-modal': featureRequestModal,
            'feature': feature
        },
        data(){
            return {
            }
        },
        mounted() {
            Hunt.renderPage('Feature Requests');
        },
        computed: {
            features() {
                return this.$store.state.features.features;
            }
        }
    }
</script>
