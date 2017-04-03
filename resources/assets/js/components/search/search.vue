<template>
    <div class="search-box mt15">
        <form @submit.prevent="search" class="search">
            <div class="input-field">
                <input v-model="query" id="search" type="search" placeholder="Search Feature" @keyup="search" required>
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>
        <ul class="collection search-results" v-if="searching && loaded">
            <li v-if="searchResults.length==0 && loaded" class="alert alert-info">No result found for this query</li>
            <search-result v-for="result in searchResults" :result="result"></search-result>
            <li style="text-align: center" v-if="loading">
                <preloader-2></preloader-2>
            </li>
        </ul>
    </div>
</template>
<style>
    ul.collection.search-results {
        position: absolute;
        z-index: 9;
        max-height: 350px;
        overflow-y: scroll;
    }
</style>
<script>
    import Hunt from '../../config/Hunt'
    import SearchResult from './components/search-result.vue'
    import preloader_2 from '../helpers/preloader-2.vue'
    export default{
        name: 'Search',
        components: {
            'search-result': SearchResult,
            'preloader-2': preloader_2
        },
        data(){
            return{
                query: '',
                loading: false,
                loaded: false,
                searching: false
            }
        },
        mounted() {
            $(document).on('click', 'body', ()=>{this.searching=false;});
            $(document).on('click', '.search-box', (e)=>{e.stopPropagation();this.searching=true;});
            Bus.$on('route-clicked', to=>{this.searching=false;});
            Bus.$on('search-results-loaded', ()=>{
                this.loading=false;
                Hunt.renderPage(this.query);
                this.loaded=true;
            });
            Hunt.infiniteScroll('.search-results', ()=>{
                this.loading = true;
                this.$store.commit('search', true);
            });
        },
        methods: {
            search(e) {
                if(this.query=='') return false;
                const that = this;
                if(window.timer!==undefined) clearTimeout(window.timer);
                window.timer = setTimeout(function () {
                    that.loading = true;
                    that.$store.dispatch('search', that.query);
                }, 200);
            }
        },
        computed: {
            searchResults() {
                return this.$store.state.search.features;
            }
        }
    }
</script>
