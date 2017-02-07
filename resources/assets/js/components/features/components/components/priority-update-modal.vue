<template>
    <div class="widget widget-status-change">
        <div class="status-btn">
            <a class="btn red waves-effect waves-light"  href="#priority_change">Update Priority <i class="material-icons left">loop</i></a>
            <div id="priority_change" class="modal">
                <div class="modal-content">
                    <form action="" @submit.prevent="updatePriority">
                        <div class="row">
                            <div class="col s9 range-field">
                                <input v-model="priority" id="priority" type="range" min="0" max="100">
                            </div>
                            <span class="col s3">{{ priority }}</span>
                            <label for="priority">Priority</label>
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
        name: 'PriorityUpdateModal',
        props: ['feature'],
        data(){
            return{
                priority: 1,
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
            updatePriority() {
                this.busy = true;
                this.post('/priorities/'+this.featureId, {value: this.priority})
                    .then(
                        success => {
                            console.log(success);
                            Hunt.toast('Priority updated.', 'success');
                            Bus.$emit('priority-updated', this.priority);
                            $("#priority_change").modal('close');
                            this.busy = false;
                        },
                        fail => {
                            Hunt.toast('Could not update priority.', 'error');
                            console.log(fail);
                            this.busy = false;
                        }
                    );
            }
        }
    }
</script>
