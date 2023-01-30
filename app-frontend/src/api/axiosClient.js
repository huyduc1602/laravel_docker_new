import axios from 'axios';
import { Common, LocalStorageKey } from '@/constants';

const apiBaseUrl = process.env.API_BASE_URL;

const axiosClient = axios.create({
    baseURL: apiBaseUrl,
    timeout: 40000,
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
});

const handleError = (error) => {
    const status = error.response.status;

    return Promise.reject({ data: error.response.data, status: status });
};

// Add a request interceptor
axiosClient.interceptors.request.use(function (config) {
    // Do something before request is sent
    const accountInfo = localStorage.getItem(LocalStorageKey.USER_INFO)
        ? JSON.parse(localStorage.getItem(LocalStorageKey.USER_INFO))
        : {};
    if (accountInfo?.accessToken) {
        config.headers['Authorization'] = accountInfo?.tokenType + ' ' + accountInfo.accessToken;
    }

    // set locale to header
    const locale = localStorage.getItem(LocalStorageKey.LOCALE) ? localStorage.getItem(LocalStorageKey.LOCALE) : Common.DEFAULT_LOCALE;
    config.headers['locale'] = locale;

    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

// Add a response interceptor
axiosClient.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    return response;
}, function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    return handleError(error);
});

export default axiosClient;