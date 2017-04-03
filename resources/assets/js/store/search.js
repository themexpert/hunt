import Hunt from '../config/Hunt'
export default {
    state: {
        query:'',
        features: [],
        page: 1,
        pagination: null,
        busy: false
    },
    mutations: {
        /**
         * Searches for query
         *
         * @param state
         * @param append
         */
        search(state, append=false) {
            if(state.busy || state.query=='') return;
            if(append) {
                if(state.pagination!=null && state.pagination.total_page>state.page) {
                    state.page++;
                }
                else {
                    Bus.$emit('search-results-loaded');
                    Hunt.toast(`You've reached the end.`);
                    return;
                }
            } else { state.page = 1; }
            state.busy = true;
            Vue.http.get(Hunt.API_URL + '/search?searchTerms='+state.query+'&page='+state.page)
                .then(
                    success => {
                        if (append)
                            state.features = state.features.concat(success.body.data);
                        else
                            state.features = success.body.data;
                        state.pagination = success.body.pagination;
                        Bus.$emit('search-results-loaded');
                        state.busy = false;
                    },
                    fail => {
                        Hunt.toast('Could not load search results (search)', 'error');
                        state.busy = false;
                    }
                );
        }
    },
    actions: {
        search({commit, state}, query) {
            if(state.query==query) return;
            state.query = query;
            commit('search');
        }
    }
}