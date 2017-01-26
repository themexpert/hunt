<template>
    <div class="secondary-content">
        <a class="waves-effect waves-light btn teal" @click="vote('up')"><i class="material-icons left">done</i> I want this</a>
        <a class="waves-effect waves-light btn teal lighten-2" @click="vote('down')"><i class="material-icons left">snooze</i> Not interested</a>
    </div>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../../config/Hunt'
    export default{
        props: ['item-id'],
        data(){
            return{
            }
        },
        methods: {
            vote(endPoint) {
                this.post('/votes/' + this.itemId + '/' + endPoint)
                    .then(
                        success => {
                            Hunt.toast(success.body.message, 'success');
                        },
                        error => {
                            console.log(error);
                            Hunt.toast('Error sending vote.', 'error');
                        }
                    );
            }
        }
    }
</script>
