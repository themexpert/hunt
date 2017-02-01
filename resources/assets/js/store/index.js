import Vue from 'vue'
import VueX from 'vuex'

Vue.use(VueX);

import auth from './auth'
import features from './features'
import releases from './releases'
import reports from './reports'
import search from './search'

const store = new VueX.Store({
    state: {
        loaded: false
    },
    modules: {
        auth: auth,
        features: features,
        releases: releases,
        reports: reports,
        search: search
    }
});

export default store;