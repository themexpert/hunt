<template>
    <div class="search-box mt15">
        <form @submit.prevent="search" class="search">
            <div class="input-field">
                <input v-model="query" id="search" type="search" :placeholder="lang.search_box" required>
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons" @click="clearQuery">close</i>
            </div>
        </form>
        <ul class="collection search-results" :class="{'not-found':searchResults.length==0}" v-if="searching && loaded && query!==''">
            <li v-if="searchResults.length==0 && loaded" class="alert alert-info" v-text="lang.no_result_message.search"></li>
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
                searching: false,
                base_title: ''
            }
        },
        mounted() {
            $(document).on('click', 'body', ()=>{if(this.searching) this.revertTitle();this.searching=false;});
            $(document).on('click', '.search-box', (e)=>{e.stopPropagation();this.searching=true;});
            Bus.$on('route-clicked', to=>{this.searching=false;});
            Bus.$on('search-results-loaded', ()=>{
                this.loading=false;
                Hunt.renderPage(this.query!==''?this.query:'Search');
                this.loaded=true;
            });
            //capture the new title
            Bus.$on("route-clicked", ()=>{this.base_title='';});
            Hunt.infiniteScroll('.search-results', ()=>{
                this.loading = true;
                this.$store.commit('search', true);
            });
        },
        methods: {
            search(e) {
                if(this.base_title==='')
                    this.base_title = window.document.title;
                const that = this;
                if(window.timer!==undefined) clearTimeout(window.timer);
                window.timer = setTimeout(function () {
                    that.loading = true;
                    that.$store.dispatch('search', that.query);
                }, 200);
            },
            clearQuery() {
                this.query = '';
                this.search();
                $("#search").focus();
            },

            revertTitle() {
                window.document.title = this.base_title;
            }
        },
        computed: {
            searchResults() {
                return this.$store.state.search.features;
            }
        },
        watch: {
            query() {
                this.search();
            }
        }
    }
</script>
