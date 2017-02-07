<template>
    <div class="widget widget-status-change">
        <div class="status-btn">
            <a class="btn red waves-effect waves-light"  href="#effort_change">Update Effort <i class="material-icons left">loop</i></a>
            <div id="effort_change" class="modal">
                <div class="modal-content">
                    <form action="" @submit.prevent="updateEffort">
                        <div class="row">
                            <div class="col s9 range-field">
                                <input v-model="effort" id="effort" type="range" min="0" max="100">
                            </div>
                            <span class="col s3">{{ effort }}</span>
                            <label for="effort">Effort</label>
                        </div>
                        <div class="input-field left-align">
                            <button type="submit" class="btn" :disabled="busy">Update <spinner v-if="busy"></spinner></button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
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
            $(".modal").modal();
        },
        methods: {
            /**
             * Updates status
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
        },
        computed: {
            /**
             * Gives the list of available statuses
             *
             * @returns {Array.<T>}
             */
            statuses() {
                let nArray = this.$store.state.features.statuses.slice(0);
                nArray.splice(0,2);
                return nArray;
            },
            preparedStatuses() {
                let statuses = [];
                this.statuses.forEach(x=>{
                    statuses.push({
                        id: x.label,
                        text: x.label
                    });
                });
                return statuses;
            }
        }
    }
</script>
