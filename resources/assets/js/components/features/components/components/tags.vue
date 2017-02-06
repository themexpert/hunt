<template>
    <div class="tags">
        <router-link v-if="isAdmin" v-for="(tag, key) in tags" :to="tagUrl(tag.name)"><span class="chip" :class="{green:key%2==0}"> {{ tag.name }} </span></router-link>
        <span v-else v-for="(tag, key) in tags" class="chip" :class="{green:key%2==0}"> {{ tag.name }} </span>
    </div>
</template>
<style>
    
</style>
<script type="text/babel">
    export default{
        props: ['tags'],
        data(){
            return{
            }
        },
        methods: {
            tagUrl(label) {
                let url = '/reports/filter/tags/';
                let ex = {};
                try {
                    this.allTags.forEach(x => {
                        if (x.label == label) {
                            url += x.value;
                            throw ex;
                        }
                    });
                } catch (e) {
                    if(e!==ex) throw e;
                }
                return url;
            }
        },
        computed: {
            allTags() {
                return this.$store.state.features.tags;
            }
        }
    }
</script>
