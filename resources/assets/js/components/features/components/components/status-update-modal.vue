<template>
    <div class="widget widget-status-change">
        <h3 class="widget-title">Status Update</h3>
        <div class="status-btn">
            <a class="btn red waves-effect waves-light"  href="#status_change">Update Status <i class="material-icons left">loop</i></a>
            <div id="status_change" class="modal">
                <div class="modal-content">
                    <form action="" @submit.prevent="updateStatus">
                        <div class="input-field">
                            <multiselect
                                    :options="statuses"
                                    :value="status"
                                    v-model="status"
                                    track-by="label"
                                    label="label"
                                    placeholder="Select Status"></multiselect>
                        </div>

                        <div class="input-field">
                            <textarea v-model="note" id="textarea1" class="materialize-textarea" placeholder="Add some note"></textarea>
                            <label for="textarea1">Status Note</label>
                        </div>

                        <div class="input-field left-align">
                            <button type="submit" class="btn">Update</button>
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
<script>
    import Hunt from '../../../../config/Hunt'
    export default{
        name: 'StatusUpdateModal',
        props: [],
        data(){
            return{
                status: null,
                note: ''
            }
        },
        methods: {
            validateInputs(data) {
                let valid= true;
                if(data.status==null) {
                    Hunt.toast('Please select a status.', 'warning');
                    valid = false;
                }
                if(data.note=='') {
                    Hunt.toast('Status note can not be null.', 'warning');
                    valid = false;
                }
                return valid;
            },
            prepareData() {
                return {
                    status: this.status!=null?this.status.value:null,
                    note: this.note
                }
            },
            updateStatus() {
                let data = this.prepareData();
                if(!this.validateInputs(data)) return false;
                this.post('', data)
                    .then(
                        success => {
                            console.log(success);
                            $("#status_change").modal('close');
                        },
                        fail => {
                            Hunt.toast('Could not update status.', 'error');
                            console.log(fail);
                        }
                    );
            }
        },
        computed: {
            statuses() {
                let nArray = this.$store.state.features.statuses.slice(0);
                nArray.splice(0,1);
                return nArray;
            }
        }
    }
</script>
