<template>
    <div class="widget widget-status-change">
        <h3 class="widget-title" v-text="lang.panel_title.status_update">Status Update</h3>
        <div class="status-btn">
            <a class="btn red waves-effect waves-light"  href="#status_change"><span v-text="lang.button.update_status">Update Status</span> <i class="material-icons left">loop</i></a>
            <div id="status_change" class="modal">
                <div class="modal-header">
                    <h4 class="title" v-text="lang.modal.status_update.title">Update Status</h4>
                </div>
                <div class="modal-content">
                    <form action="" @submit.prevent="updateStatus">
                        <div class="input-field">
                            <select2 v-model="status" :placeholder="lang.placeholder.dropdown.status">
                                <option v-for="s in statuses" :value="s.label">{{ s.label }}</option>
                            </select2>
                        </div>
                        <div class="input-field">
                            <input id="subject" type="text" v-model="subject" :placeholder="lang.modal.status_update.subject.placeholder">
                            <label for="subject" v-text="lang.modal.status_update.subject.label">Subject</label>
                        </div>
                        <div class="input-field">
                            <textarea v-model="message" id="textarea1" class="materialize-textarea" :placeholder="lang.modal.status_update.message.placeholder"></textarea>
                            <label for="textarea1" v-text="lang.modal.status_update.message.label">Status Note</label>
                        </div>

                        <div class="input-field left-align">
                            <a class=" modal-action modal-close waves-effect waves-green btn-flat right" v-text="lang.button.close">Close</a>
                            <button type="submit" class="btn" :disabled="busy"><span v-text="lang.modal.status_update.btn_status">Update</span> <spinner v-if="busy"></spinner></button>
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
            this.status = this.feature.status.type;
            /**
             * Initiates modal for sub-component
             */
            $(".modal").modal({dismissible:false});
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
                            Hunt.toast('Status updated.', 'success');
                            Bus.$emit('status-updated', {
                                type: this.status,
                                subject: this.subject,
                                message: this.message
                            });
                            this.subject = '';
                            this.message = '';
                            $("#status_change").modal('close');
                            this.busy = false;
                        },
                        fail => {
                            Hunt.toast('Could not update status.', 'error');
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
            }
        },
        watch: {
            'feature.status.type' () {
                this.status = this.feature.status.type;
            }
        }
    }
</script>
