import Hunt from '../config/Hunt'
import router from '../router'
export default {
    state: {
        user: null,
        redirectTo: null
    },
    mutations: {
        /**
         * Sets the user data at logged in and emits event loggedIn
         *
         * @param state
         * @param user
         */
        loggedIn(state, user) {
            state.user = user;
            Bus.$emit('loggedIn');
        },
        /**
         * Removes the auth data
         *
         * @param state
         */
        loggedOut(state) {
            window.Laravel.token = null;
            state.user = null;
        }
    },
    actions: {
        /**
         * Validates authentication and updates token
         *
         * @param ctx
         * @param redirectTo
         */
        loggedIn(ctx, redirectTo) {
            Vue.http.get(Hunt.BASE_URL + '/refresh-token')
                .then(
                    success => {
                        window.Laravel.token=success.body.token;
                        Hunt.updateToken(success.body.token);
                        ctx.commit('loggedIn', success.body.user);
                        if(redirectTo!==undefined) router.push(redirectTo);
                    },
                    fail => {
                        Hunt.toast('Error refreshing token.', 'error');
                    }
                );
        },
        /**
         * Invokes loggedOut
         *
         * @param ctx
         */
        loggedOut(ctx) {
            ctx.commit('loggedOut');
        }
    },
    getters: {
        /**
         * Checks if user logged in
         *
         * @param state
         * @returns {boolean}
         */
        isLoggedIn(state) {
            return state.user!==null;
        },
        /**
         * Gives user email (if authenticated)
         *
         * @param state
         * @returns {string|*}
         */
        userEmail(state) {
            return state.user!==null?state.user.email:null;
        },
        /**
         * Gives user nick name (if authenticated)
         * @param state
         */
        userName(state) {
            return state.user!==null?state.user.name:null;
        }
    }
}