<template>
    <div class="card-action center-align">
        <a class="waves-effect waves-light btn" href="#modal_comment_form"><i class="material-icons left">add</i> <span v-text="lang.modal.comment.title">Add a comment</span></a>

        <!-- Modal Structure -->
        <div id="modal_comment_form" class="modal bottom-sheet comment-form">
            <div class="container">
                <div class="modal-content">

                    <form class="" action="" @submit.prevent="submitComment">
                        <div class="input-field">
                            <textarea v-model="comment" id="textarea1" class="materialize-textarea" :placeholder="lang.modal.comment.comment.label"></textarea>
                            <label for="textarea1" v-text="lang.modal.comment.comment.label">Add Comment</label>
                        </div>

                        <div class="input-field left-align">
                            <button type="submit" class="btn" :disabled="busy"><span v-text="lang.modal.comment.btn_comment">Save comment</span> <i class="material-icons left">done</i> <spinner v-if="busy"></spinner></button>
                            <a class="modal-action modal-close waves-effect waves-green btn grey" v-text="lang.button.close">Close</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../../config/Hunt'
    export default{
        name: 'AddCommentModal',
        props: ['feature-id'],
        data(){
            return{
                comment: '',
                busy: false
            }
        },
        mounted() {
            /**
             * Initiates the modal for sub-component
             */
            $(".modal").modal();
        },
        methods: {
            /**
             * Submits new comment
             */
            submitComment() {
                if(this.comment=='') {
                    Hunt.toast('Comment can not be empty.', 'warning');
                    return;
                }
                this.busy = true;
                this.post('/features/'+this.featureId+'/comments', {message: this.comment})
                    .then(
                        success=>{
                            Hunt.toast('Your comment has been saved.', 'success');
                            Bus.$emit('new-comment', success.body.comment);
                            this.comment = '';
                            $("#modal_comment_form").modal('close');
                            this.busy = false;
                        },
                        fail=>{
                            this.busy = false;
                            Hunt.toast('Could not post comment.', 'error');
                            console.log(fail);
                        }
                    );
            }
        }
    }
</script>
