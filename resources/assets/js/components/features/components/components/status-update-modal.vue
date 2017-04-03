<template>
    <div class="widget widget-status-change">
        <h3 class="widget-title">Status Update</h3>
        <div class="status-btn">
            <a class="btn red waves-effect waves-light"  href="#status_change">Update Status <i class="material-icons left">loop</i></a>
            <div id="status_change" class="modal">
                <div class="modal-header">
                    <h4 class="title">Update Status</h4>
                </div>
                <div class="modal-content">
                    <form action="" @submit.prevent="updateStatus">
                        <div class="input-field">
                            <select2
                                    :options="preparedStatuses"
                                    :selected-value="feature.status.type"
                                    :update="setStatus"></select2>
                        </div>
                        <div class="input-field">
                            <input id="subject" type="text" v-model="subject">
                            <label for="subject">Subject</label>
                        </div>
                        <div class="input-field">
                            <textarea v-model="message" id="textarea1" class="materialize-textarea" placeholder="Add some note"></textarea>
                            <label for="textarea1">Status Note</label>
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
        name: 'StatusUpdateModal',
        props: ['feature'],
        data(){
            return{
                featureId: null,
                status: null,
                subject: '',
                message: '',
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
             * Sets status
             */
            setStatus(status) {
                this.status = status;
                const statusItem = this.$store.state.features.statuses.find(x=>{ return x.label==status.toUpperCase(); });
                this.subject = statusItem.subject;
                this.message = statusItem.message;
                Vue.nextTick(()=>{Materialize.updateTextFields();});
            },
            /**
             * Validates inputs
             */
            validateInputs(data) {
                let valid= true;
                if(this.status==null) {
                    Hunt.toast('Please select a status.', 'warning');
                    valid = false;
                }
                if(data.subject=='') {
                    Hunt.toast('Subject can not be empty.', 'warning');
                    valid = false;
                }
                if(data.message=='') {
                    Hunt.toast('Message can not be empty.', 'warning');
                    valid = false;
                }
                return valid;
            },
            /**
             * Prepares data to be sent
             */
            prepareData() {
                return {
                    subject: this.subject,
                    message: this.message
                }
            },
            /**
             * Updates status
             */
            updateStatus() {
                let data = this.prepareData();
                if(!this.validateInputs(data)) return false;
                let endPoint = '';
                switch (this.status) {
                    case "RELEASED":
                        endPoint='/releases/';
                        break;
                    case "WIP":
                        endPoint='/plans/';
                        break;
                    case "DECLINED":
                        endPoint='/declines/';
                        break;
                }
                this.busy = true;
                this.post(endPoint+this.featureId, {status: data})
                    .then(
                        success => {
                            console.log(success);
                            Hunt.toast('Status updated.', 'success');
                            Bus.$emit('status-updated', {
                                type: this.status,
                                subject: this.subject
                            });
                            this.subject = '';
                            this.message = '';
                            $("#status_change").modal('close');
                            this.busy = false;
                        },
                        fail => {
                            Hunt.toast('Could not update status.', 'error');
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
