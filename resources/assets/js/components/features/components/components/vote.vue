<template>
    <div :class="{'vote-btn':single!=undefined, 'secondary-content':single==undefined}">
        <a v-if="vote==null || vote==1" :disabled="voteClicked" class="waves-effect waves-light btn teal" @click="sendVote('up')"><i class="material-icons left">done</i> I want this</a>
        <a v-if="vote==null || vote==-1" :disabled="voteClicked" class="waves-effect waves-light btn teal lighten-2" @click="sendVote('down')"><i class="material-icons left">snooze</i> Not interested</a>
    </div>
</template>
<style>

</style>
<script type="text/babel">
    import Hunt from '../../../../config/Hunt'
    export default{
        props: ['item-id', 'voted', 'single'],
        data(){
            return{
                voteClicked: false,
                vote: null
            }
        },
        mounted() {
            this.vote = this.voted || null;
            this.voteClicked = this.voted != undefined;
            if(this.single) {
                for(let i=0;i<this.$store.state.features.features.length;i++) {
                    let x = this.$store.state.features.features[i];
                    if(x.id!=this.itemId) continue;
                    this.voteClicked = x.voted!=undefined;
                    this.vote = x.voted;
                    break;
                }
            }
        },
        methods: {
            /**
             * Send the vote to server
             *
             * @param endPoint
             */
            sendVote(endPoint) {
                this.voteClicked = true;
                this.post('/votes/' + this.itemId + '/' + endPoint)
                    .then(
                        success => {
                            Hunt.toast(success.body.message, 'success');
                            Bus.$emit('new-vote', endPoint=='up'?{up:1}:{down:1});
                            this.vote=endPoint=='up'?1:-1;
                            this.$store.commit('new_vote', {type: endPoint, id: this.itemId});
                        },
                        error => {
                            console.log(error);
                            Hunt.toast('Error sending vote.', 'error');
                            this.voteClicked = false;
                        }
                    );
            }
        }
    }
</script>
