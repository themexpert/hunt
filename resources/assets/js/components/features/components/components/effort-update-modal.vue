<template>
    <div class="widget widget-status-change">
        <div class="status-btn">
            <a class="btn red waves-effect waves-light"  href="#effort_change"><span v-text="lang.button.update_effort">Update Effort</span> <i class="material-icons left">loop</i></a>
            <div id="effort_change" class="modal">
                <div class="modal-header">
                    <h4 class="title" v-text="lang.modal.effort_update.title">Update Effort</h4>
                </div>
                <div class="modal-content">
                    <form action="" @submit.prevent="updateEffort">
                        <div class="row">
                            <div class="col s9 range-field">
                                <input v-model="effort" id="effort" type="range" min="0" max="100">
                            </div>
                            <span class="col s3">{{ effort }}</span>
                            <label for="effort" v-text="lang.modal.effort_update.effort.label">Effort</label>
                        </div>
                        <div class="input-field left-align">
                            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right" v-text="lang.button.close">Close</a>
                            <button type="submit" class="btn" :disabled="busy"><span v-text="lang.modal.effort_update.btn_effort">Update</span> <spinner v-if="busy"></spinner></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.widget-->
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../../config/Hunt'
    export default{
        name: 'EffortUpdateModal',
        props: ['feature'],
        data(){
            return{
                effort: 1,
                busy: false
            }
        },
        mounted() {
            this.featureId = this.feature.id;
            /**
             * Initiates modal for sub-component
             */
            $(".modal").modal({dismissible:false});
        },
        methods: {
            /**
             * Updates effort
             */
            updateEffort() {
                this.busy = true;
                this.post('/efforts/'+this.featureId, {value: this.effort})
                    .then(
                        success => {
                            console.log(success);
                            Hunt.toast('effort updated.', 'success');
                            Bus.$emit('effort-updated', this.effort);
                            $("#effort_change").modal('close');
                            this.busy = false;
                        },
                        fail => {
                            Hunt.toast('Could not update effort.', 'error');
                            console.log(fail);
                            this.busy = false;
                        }
                    );
            }
        }
    }
</script>
