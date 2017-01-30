<template>
    <div class="card-action center-align">
        <a class="waves-effect waves-light btn" href="#modal_comment_form"><i class="material-icons left">add</i> Add a comment</a>

        <!-- Modal Structure -->
        <div id="modal_comment_form" class="modal bottom-sheet comment-form">
            <div class="container">
                <div class="modal-content">

                    <form class="" action="" @submit.prevent="submitComment">
                        <div class="input-field">
                            <textarea v-model="comment" id="textarea1" class="materialize-textarea" placeholder="You need to add some text to your comment."></textarea>
                            <label for="textarea1">Add Comment</label>
                        </div>

                        <div class="input-field left-align">
                            <button type="submit" class="btn" :disabled="busy">Save comment <i class="material-icons left">done</i></button>
                            <a class="modal-action modal-close waves-effect waves-green btn grey">Close</a>
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
            $(".modal").modal();
        },
        methods: {
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
                            Bus.$emit('new-comment', {comment: this.comment});
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
