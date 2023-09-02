/* eslint-disable prefer-template */
/* eslint-disable dot-notation */
/* eslint-disable @typescript-eslint/dot-notation */
import axios from 'axios';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.headers.common['Access-Control-Allow-origin'] = '*';
window.axios.defaults.headers.common['X-Referer'] = window.location.hostname;
axios.defaults.withCredentials = true;

window.sanctum = async (url, config = {}) => {
    await window.axios
        .get('/sanctum/csrf-cookie', { baseURL: import.meta.env.VITE_APP_URL })
        .catch((error) => {
            const data = error.response?.data;
            const headers = error.response?.headers;

            console.error({ data, headers });
        });
    return window.axios(url, { baseURL: '/api/v1', ...config });
};
