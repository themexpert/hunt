import Hunt from '../config/Hunt'
export default {
    state: {
        filter_type: null,
        filter_value: null,
        features: [],
        pagination: null,
        page: 1,
        busy: false
    },
    mutations: {
        /**
         * Load features for report
         *
         * @param state
         * @param append
         */
        loadFeatures(state, append=false) {
            if(state.busy) return;
            if(append) {
                if(state.pagination!=null && state.pagination.total_page>state.page) {
                    state.page++;
                }
                else {
                    Bus.$emit('reports-list-loaded');
                    Hunt.toast(`You've reached the end.`);
                    return;
                }
            } else { state.page = 1; }
            let endPoint = '/';
            if(state.filter_type==null) {
                endPoint = '/filters/access/any';
            }
            else if(state.filter_type=='access') {
                endPoint = '/filters/access/'+state.filter_value
            }
            else if(state.filter_type=='tags') {
                endPoint = '/filters/tags/'+state.filter_value
            }
            state.busy = true;
            Vue.http.get(Hunt.API_URL+endPoint+'?page='+state.page)
                .then(
                    success => {
                        if(append)
                            state.features = state.features.concat(success.body.data);
                        else
                            state.features = success.body.data;
                        state.pagination = success.body.pagination;
                        state.busy = false;
                        Bus.$emit('reports-list-loaded');
                    },
                    fail => {
                        Hunt.toast('Could not load features list (reports store)', 'error');
                        console.log(fail);
                        state.busy = false;
                    }
                );
        }
    },
    actions: {
        /**
         * Reset the criteria and reload
         *
         * @param commit
         * @param state
         * @param filter
         */
        reloadFeatures({commit, state}, filter) {
            if(filter==null) {
                state.filter_type = null;
                state.filter_value = null;
            }
            else
            {
                state.filter_type = filter.type;
                state.filter_value = filter.value;
            }
            commit('loadFeatures');
        }
    }
}