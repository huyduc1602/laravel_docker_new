import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import { Common, LocalStorageKey } from '@/constants';
import { authApi } from '@/api';
import { clearErrorMessage, clearSearchCondition } from '@/slices/appSlice';
import moment from 'moment';

const user = JSON.parse(localStorage.getItem(LocalStorageKey.USER_INFO));

export const login = createAsyncThunk(
    'auth/login',
    async ({ email, password, acceptTermOfService = false, isRedirectPage = true }, thunkAPI) => {
        await thunkAPI.dispatch(clearErrorMessage());

        try {
            const { data } = await authApi.login(email, password, acceptTermOfService);
            localStorage.setItem(LocalStorageKey.USER_INFO, JSON.stringify(data.data));
            localStorage.setItem(LocalStorageKey.LOGIN_AT, moment().format(Common.FULL_DATE_TIME_FORMAT_WITH_DASH));
            localStorage.removeItem(LocalStorageKey.LOGOUT_FLAG);
            localStorage.removeItem(LocalStorageKey.UUID);
            return {
                user: data.data,
                isRedirectPage,
            };
        } catch (error) {
            return thunkAPI.rejectWithValue(error);
        }
    },
);

export const logout = createAsyncThunk('auth/logout', async (_, thunkAPI) => {
    const userInfo = localStorage.getItem(LocalStorageKey.USER_INFO);

    if (userInfo) {
        try {
            thunkAPI.dispatch(clearErrorMessage());
            thunkAPI.dispatch(clearSearchCondition());

            const response = await authApi.logout();
            localStorage.removeItem(LocalStorageKey.USER_INFO);
            localStorage.removeItem(LocalStorageKey.LOGIN_AT);

            const message = response?.data?.message;

            return {
                message,
            };
        } catch (error) {
            localStorage.removeItem(LocalStorageKey.USER_INFO);
            return thunkAPI.rejectWithValue(error);
        }
    }
});

const initialState = user
    ? { isLoggedIn: true, user, isRedirectPage: true }
    : { isLoggedIn: false, user: null, isRedirectPage: true };

export const authSlice = createSlice({
    name: 'auth',
    initialState: initialState,
    extraReducers: {
        [login.fulfilled]: (state, action) => {
            state.isLoggedIn = true;
            state.user = action.payload.user;
            state.isRedirectPage = action.payload.isRedirectPage;
        },
        [login.rejected]: (state, action) => {
            state.isLoggedIn = false;
            state.user = null;
            state.isRedirectPage = true;
        },
        [logout.fulfilled]: (state, action) => {
            state.isLoggedIn = false;
            state.user = null;
            state.isRedirectPage = true;
        },
        [logout.rejected]: (state, action) => {
            state.isLoggedIn = false;
            state.user = null;
            state.isRedirectPage = true;
        },
    },
    reducers: {
        setIsLoggedIn: (state, action) => {
            state.isLoggedIn = action.payload;
        },
        setIsRedirectPage: (state, action) => {
            state.isRedirectPage = action.payload;
        },
    },
});

const { reducer, actions } = authSlice;

export const {
    setIsLoggedIn,
    setIsRedirectPage,
} = actions;

export default reducer;