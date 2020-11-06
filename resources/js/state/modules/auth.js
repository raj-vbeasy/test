// import { getFirebaseBackend } from '@/authUtils'
import Vue from 'vue';

export const state = {
    accessToken: localStorage.getItem('access_token'),
    refreshToken: localStorage.getItem('refresh_token'),
    expiresAt: localStorage.getItem('expires_at')
}

export const mutations = {
    SET_TOKENS(state, tokens) {
        let expiresAt = ((Number(new Date()) / 1000) + tokens.expires_in) * 1000;
        state.accessToken = tokens.access_token;
        state.refreshToken = tokens.refresh_token;
        state.expiresAt = expiresAt;

        localStorage.setItem('access_token', tokens.access_token);
        localStorage.setItem('refresh_token', tokens.refresh_token);
        localStorage.setItem('expires_at', '' + expiresAt);
    },
    PURGE_TOKENS(state) {
        localStorage.removeItem('access_token');
        localStorage.removeItem('refresh_token');
        localStorage.removeItem('expires_at');

        state.accessToken = null;
        state.refreshToken = null;
        state.expiresAt = null;
    }
}

export const getters = {
    // Whether the user is currently logged in.
    loggedIn: state => !!state.accessToken,
    accessToken: state => state.accessToken
}

export const actions = {
    // This is automatically run in `src/state/store.js` when the app
    // starts, along with any other actions named `init` in other modules.
    // eslint-disable-next-line no-unused-vars
    init({ state, dispatch }) {
        dispatch('validate')
    },

    // Logs in the current user.
    logIn({ commit, dispatch, getters }, { email, password } = {}) {
        if (getters.loggedIn) return dispatch('validate')
        return Vue.prototype.$http.post('oauth/token', {
            'grant_type': 'password',
            'client_id': process.env.MIX_OAUTH_CLIENT_ID,
            'client_secret': process.env.MIX_OAUTH_CLIENT_SECRET,
            'username': email,
            'password': password,
            'scope': '*',
        }).then(response => {
            commit('SET_TOKENS', response.data)
        });
    },

    // Fetch access token from refresh token
    refreshAccessToken({ commit, state }) {
        return Vue.prototype.$http.post('oauth/token', {
            'grant_type': 'refresh_token',
            'client_id': process.env.MIX_OAUTH_CLIENT_ID,
            'client_secret': process.env.MIX_OAUTH_CLIENT_SECRET,
            'refresh_token': state.refreshToken,
            'scope': '*',
        }).then(response => {
            commit('SET_TOKENS', response.data)
        });
    },

    // Logs out the current user.
    logOut({ commit }) {
        // eslint-disable-next-line no-unused-vars
        commit('PURGE_TOKENS')
    },

    // register the user
    // eslint-disable-next-line no-unused-vars
    resetPassword({ commit, dispatch, getters }, { email } = {}) {
        if (getters.loggedIn) return dispatch('validate')

        // return getFirebaseBackend().forgetPassword(email).then((response) => {
        //     const message = response.data
        //     return message
        // });
    },

    // Validates the current user's token and refreshes it
    // with new data from the API.
    // eslint-disable-next-line no-unused-vars
    validate({ commit, state, dispatch }) {
        if (!state.accessToken) return Promise.resolve(null);
        let remainingSeconds = ((state.expiresAt - Number(new Date())) / 1000);
        if (remainingSeconds > 600) {
            return true;
        } else {
            return dispatch('refreshAccessToken');
        }
    },
}
