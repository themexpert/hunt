<template>
    <div v-if="show" :class="{'vote-btn':single!=undefined, 'secondary-content':single==undefined}">
        <a :disabled="vote==1" class="waves-effect waves-light btn teal" @click="sendVote('up')"><i class="material-icons left">done</i> <span v-text="lang.button.interested">I want this</span></a>
        <a :disabled="vote==-1" class="waves-effect waves-light btn teal lighten-2" @click="sendVote('down')"><i class="material-icons left">snooze</i> <span v-text="lang.button.not_interested">Not interested</span></a>
    </div>
    <div v-else :class="{'vote-btn':single!=undefined, 'secondary-content':single==undefined}">
        <a class="waves-effect waves-light btn" :style="{color: '#ffffff', backgroundColor: (type==='RELEASED'?'#4caf50':'#0d47a1')}">
            <span v-text="typeText"></span>
        </a>
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
            }
        },
        computed: {
            vote() {
                return this.feature.userVoted;
            },
            type() {
                return this.feature.status.type;
            },
            typeText() {
                return this.lang.status[this.type.toLowerCase()];
            },
            show() {
                return ['RELEASED','DECLINED'].indexOf(this.type)<0;
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
                this.post('/votes/' + this.feature.id + '/' + endPoint)
                    .then(
                        success => {
                            Hunt.toast(success.body.message, 'success');
                            this.$store.commit('new_vote', endPoint==='up'?{id: this.feature.id, up:1}:{id: this.feature.id, down:1});
                            Bus.$emit('new-vote', endPoint==='up'?{id: this.feature.id, up:1}:{id: this.feature.id, down:1});
                            this.busy = false;
                        },
                        error => {
                            Hunt.toast('Error sending vote.', 'error');
                            this.busy = false;
                        }
                    );
            }
        }
    }
</script>
