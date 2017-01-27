import Hunt from '../config/Hunt'
export default {
    state: {
        user: null,
        redirectTo: null
    },
    mutations: {
        loggedIn(state, user) {
            state.user = user;
            Vue.http.get(Hunt.BASE_URL + '/refreshToken')
                .then(
                    success => {
                        window.Laravel.token=success.body.token;
                        Bus.$emit('loggedIn');
                    },
                    fail => {
                        Hunt.toast('Error refreshing token.', 'error');
                    }
                );
        },
        loggedOut(state) {
            window.Laravel.token = null;
            state.user = null;
        }
    },
    actions: {
        loggedIn(ctx) {
            Vue.http.get(Hunt.BASE_URL + '/profile')
                .then(
                    success => {
                        ctx.commit('loggedIn', success.body.user);
                    },
                    fail => {
                        console.log(fail);
                        Hunt.toast('Something went wrong. (profile - store)', 'error');
                    }
                );
        },
        loggedOut(ctx) {
            ctx.commit('loggedOut');
        }
    },
    getters: {
        isLoggedIn(state) {
            return state.user!=null;
        },
        userEmail(state) {
            return state.user.email;
        },
        userName(state) {
            return state.user.name;
        }
    }
}