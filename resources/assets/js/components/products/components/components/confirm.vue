<template>
    <div id="modal-confirm" class="modal">
        <div class="modal-content">
            <h4 v-text="lang.modal.confirm.title">Please Confirm</h4>
            <p v-text="message"></p>
        </div>
        <div class="modal-footer">
            <a @click="done(true)" class="modal-action waves-effect waves-green btn-flat" v-text="lang.modal.confirm.btn_confirm">CONFIRM</a>
            <a @click="done(false)" class="modal-action waves-effect waves-green btn-flat" v-text="lang.modal.confirm.btn_cancel">CANCEL</a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "ConfirmModal",
        props: ['message', 'item'],
        data() {
            return {
                modal: null
            }
        },
        mounted() {
            this.modal = $("#modal-confirm");
            this.modal.modal({confirm:()=>{this.$emit('confirm', false)}});
            this.modal.modal('open');
        },
        methods: {
            done(output) {
                this.modal.modal('close');
                this.$emit('confirm', output);
            }
        }
    }
</script>