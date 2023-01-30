import { createSlice } from '@reduxjs/toolkit';
import { generateDefaultBookingData } from '@/helpers/Common';

const propDataDefault = {
    genders: null,
    jobs: null,
    hours: null,
    minutes: null,
    prefectures: null,
    occupations: null,
};

const popupAlertDefault = {
    isShow: false,
    type: 'error',//error|success
    message: '',
    btnText: '',
};

const defaultInfoFiles = {
    termOfUse: {
        name: '',
        path: '',
        version: '',
    },
};

const promptConfirmDefault = {
    showPrompt: false,
    lastLocation: null,
    confirmedNavigation: false,
    confirmLogout: false,
    isLogout: false,
};

export const appSlice = createSlice({
    name: 'app',
    initialState: {
        isLoading: false,
        masters: propDataDefault,
        isShowPickBookingModal: false,
        pickBookingData: generateDefaultBookingData(),
        isShowSearchBookingModal: false,
        searchBookingData: {},
        isShowMenuMobile: false,
        hasError: false,
        errorMessage: null,
        popupAlert: popupAlertDefault,
        promptConfirm: promptConfirmDefault,
        infoFiles: defaultInfoFiles,
    },
    reducers: {
        showLoading: (state, action) => {
            state.isLoading = action.payload ?? true;
        },
        setGenders: (state, action) => {
            state.masters.genders = action.payload;
        },
        setJobs: (state, action) => {
            state.masters.jobs = action.payload;
        },
        setHours: (state, action) => {
            state.masters.hours = action.payload;
        },
        setMinutes: (state, action) => {
            state.masters.minutes = action.payload;
        },
        setPrefectures: (state, action) => {
            state.masters.prefectures = action.payload;
        },
        setOccupations: (state, action) => {
            state.masters.occupations = action.payload;
        },

        clearMasters: (state) => {
            state.masters = propDataDefault;
        },
        enablePickBookingModal: (state) => {
            state.isShowPickBookingModal = true;
        },
        disablePickBookingModal: (state) => {
            state.isShowPickBookingModal = false;
        },
        setPickBookingData: (state, action) => {
            state.pickBookingData = {
                ...state.pickBookingData,
                ...action.payload,
            };
        },
        enableSearchBookingModal: (state) => {
            state.isShowSearchBookingModal = true;
        },
        disableSearchBookingModal: (state) => {
            state.isShowSearchBookingModal = false;
        },
        setSearchBookingData: (state, action) => {
            state.searchBookingData = {
                ...state.searchBookingData,
                ...action.payload,
            };
        },
        showMenuMobile: (state) => {
            state.isShowMenuMobile = true;
        },
        hideMenuMobile: (state) => {
            state.isShowMenuMobile = false;
        },
        setErrorMessage: (state, action) => {
            state.hasError = true;
            state.errorMessage = action.payload;
        },
        clearErrorMessage: (state) => {
            state.hasError = false;
            state.errorMessage = null;
        },
        clearSearchCondition: (state) => {
            state.searchBookingData = {};
            state.pickBookingData = generateDefaultBookingData();
        },
        showPopupAlert: (state, action) => {
            state.popupAlert = Object.assign({
                popupAlertDefault,
                ...action.payload,
            });
            state.popupAlert.isShow = true;
        },
        closePopupAlert: (state) => {
            state.popupAlert.isShow = false;
        },
        showPromptConfirm: (state) => {
            state.promptConfirm.showPrompt = true;
        },
        hidePromptConfirm: (state) => {
            state.promptConfirm.showPrompt = false;
        },
        setPromptLastLocation: (state, action) => {
            state.promptConfirm.lastLocation = action.payload;
        },
        setPromptConfirmedNavigation: (state, action) => {
            state.promptConfirm.confirmedNavigation = action.payload;
        },
        setPromptConfirmLogout: (state, action) => {
            state.promptConfirm.confirmLogout = action.payload;
        },
        setPromptIsLogout: (state, action) => {
            state.promptConfirm.isLogout = action.payload;
        },
        setInfoFiles: (state, action) => {
            state.infoFiles = action.payload;
        },
    },
});

const { reducer, actions } = appSlice;
export const {
    showLoading,
    setGenders,
    setJobs,
    setHours,
    setMinutes,
    setPrefectures,
    setOccupations,
    clearMasters,
    enablePickBookingModal,
    disablePickBookingModal,
    setPickBookingData,
    enableSearchBookingModal,
    disableSearchBookingModal,
    setSearchBookingData,
    showMenuMobile,
    hideMenuMobile,
    setErrorMessage,
    clearErrorMessage,
    clearSearchCondition,
    showPopupAlert,
    closePopupAlert,
    showPromptConfirm,
    hidePromptConfirm,
    setPromptLastLocation,
    setPromptConfirmedNavigation,
    setPromptConfirmLogout,
    setPromptIsLogout,
    setInfoFiles,
} = actions;
export default reducer;
