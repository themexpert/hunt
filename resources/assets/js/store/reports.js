import Hunt from '../config/Hunt'
export default {
    state: {
        filter_type: null,
        filter_value: null,
        features: []
    },
    mutations: {
        loadFeatures(state, append) {
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
            Vue.http.get(Hunt.API_URL+endPoint)
                .then(
                    success => {
                        if(append==undefined)
                            state.features = success.body.features;
                    },
                    fail => {
                        Hunt.toast('Could not load features list (reports store)', 'error');
                        console.log(fail);
                    }
                );
        }
    },
    actions: {
        loadFeatures(commit, page) {

        },
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