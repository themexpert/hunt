<template>
    <li class="collection-item avatar status-wip">
        <i class="material-icons circle">loop</i>
        <h4 class="title"><a href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus eligendi laudantium possimus ratione voluptas.</a></h4>
        <div class="tags"><span class="chip">Tag1</span> <span class="chip green">Tag2</span></div>
        <div class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae cupiditate dolorem dolores eum facere facilis harum impedit maiores minima...
        </div>

        <div class="secondary-content">
            <a class="waves-effect waves-light btn teal"><i class="material-icons left">done</i> I want this</a>
            <a class="waves-effect waves-light btn teal lighten-2"><i class="material-icons left">snooze</i> Not interested</a>
        </div>

    </li>
</template>
<style>
    
</style>
<script>
    export default{
        name: 'Feature List Item',
        props: ['item'],
        data(){
            return{

            }
        },
        computed: {

        }
    }
</script>
