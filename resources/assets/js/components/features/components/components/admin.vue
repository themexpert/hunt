<template>
    <div>
        <a class="btn waves-effect waves-light" @click="editFeature"><span>Edit</span> <i class="material-icons left">edit</i></a>
        <a v-if="isAdmin" class="btn red waves-effect waves-light" @click="deleteFeature"><span>Delete</span> <i class="material-icons left">delete</i></a>

        <confirm v-if="showDeleteModal" message="Are you sure you want to delete this feature?" @confirm="confirmed"></confirm>
        <edit v-if="showEditModal" :feature="feature" @closed="edit_closed"></edit>
    </div>
</template>
<script>
    import Hunt from './../../../../config/Hunt'
    import confirm_modal from './../../../helpers/confirm.vue'
    import edit_feature_request_modal from './components/edit-feature-request-modal.vue'

    export default {
        props: ['feature'],
        components: {
            "confirm": confirm_modal,
            'edit': edit_feature_request_modal
        },
        data() {
            return {
                showDeleteModal: false,
                showEditModal: false
            }
        },
        methods: {
            deleteFeature() {
                this.showDeleteModal = true;
            },
            confirmed(o) {
                const that = this;
                setTimeout(()=>{
                    that.showDeleteModal = false;
                }, 300);
                if(!o) return;
                this.delete('/products/'+this.feature.product_id+'/features/'+this.feature.id)
                    .then(response=>{
                        Hunt.toast(response.data.message, 'success');
                        const that=this;
                        setTimeout(()=>{
                            that.$store.commit('feature_deleted', that.feature.id);
                        }, 100);
                        this.$router.push('/products/'+this.feature.product_id+'/features');
                    })
                    .catch(error=>{
                        Hunt.toast("Could not delete feature request");
                    });
            },
            editFeature() {
                this.showEditModal = true;
            },
            edit_closed() {
                const that = this;
                setTimeout(()=>{
                    that.showEditModal = false;
                }, 300);
            }

        },
    }
</script>