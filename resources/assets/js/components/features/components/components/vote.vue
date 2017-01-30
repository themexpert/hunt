<template>
    <div :class="{'vote-btn':single!=undefined, 'secondary-content':single==undefined}">
        <a class="waves-effect waves-light btn teal" @click="vote('up')"><i class="material-icons left">done</i> I want this</a>
        <a class="waves-effect waves-light btn teal lighten-2" @click="vote('down')"><i class="material-icons left">snooze</i> Not interested</a>
    </div>
</template>
<style>
    
</style>
<script>
    import Hunt from '../../../../config/Hunt'
    export default{
        props: ['item-id', 'single'],
        data(){
            return{
            }
        },
        methods: {
            /**
             * Send the vote to server
             *
             * @param endPoint
             */
            vote(endPoint) {
                this.post('/votes/' + this.itemId + '/' + endPoint)
                    .then(
                        success => {
                            Hunt.toast(success.body.message, 'success');
                            Bus.$emit('new-vote', endPoint=='up'?{up:1}:{down:1});
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
