<template>
    <div :class="{'vote-btn':single!=undefined, 'secondary-content':single==undefined}">
        <a :disabled="vote==1" class="waves-effect waves-light btn teal" @click="sendVote('up')"><i class="material-icons left">done</i> I want this <spinner v-if="busy"></spinner></a>
        <a :disabled="vote==-1" class="waves-effect waves-light btn teal lighten-2" @click="sendVote('down')"><i class="material-icons left">snooze</i> Not interested <spinner v-if="busy"></spinner></a>
    </div>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../../config/Hunt'
    export default{
        props: ['feature', 'single'],
        data(){
            return{
                busy: false
            }
        },
        computed: {
            vote() {
                return this.feature.userVoted;
            }
        },
        methods: {
            /**
             * Send the vote to server
             *
             * @param endPoint
             */
            sendVote(endPoint) {
                this.busy = true;
                this.feature.userVoted = (endPoint=='up'?1:-1);
                this.post('/votes/' + this.feature.id + '/' + endPoint)
                    .then(
                        success => {
                            Hunt.toast(success.body.message, 'success');
                            Bus.$emit('new-vote', endPoint=='up'?{up:1}:{down:1});
                            let vote=endPoint=='up'?1:-1;
                            this.busy = false;
                        },
                        error => {
                            console.log(error);
                            Hunt.toast('Error sending vote.', 'error');
                            this.busy = false;
                            this.feature.userVoted = 0;
                        }
                    );
            }
        }
    }
</script>
