import Hunt from '../config/Hunt'
export default {
    state: {
        features: [],
        page: 1,
        pagination: null,
        busy: false
    },
    mutations: {
        /**
         * Load released features
         *
         * @param state
         * @param append
         */
        loadReleasedFeatures(state, append=false) {
            if(state.busy) return;
            if(append) {
                if(state.pagination!=null && state.pagination.total_page>state.page) {
                    state.page++;
                }
                else {
                    Bus.$emit('releases-list-loaded');
                    return;
                }
            } else { state.page = 1; }
            state.busy = true;
            Vue.http.get(Hunt.API_URL + '/features/released?page='+state.page)
                .then(
                    success => {
                        if (append)
                            state.features = state.features.concat(success.body.data);
                        else
                            state.features = success.body.data;
                        state.pagination = success.body.pagination;
                        Bus.$emit('releases-list-loaded');
                        state.busy = false;
                    },
                    fail => {
                        Hunt.toast('Could not load released features (load released features)', 'error');
                        state.busy = false;
                    }
                );
        }
    },
    actions: {
    }
}