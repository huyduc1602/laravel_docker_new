import moment from 'moment';
import { Common, LocalStorageKey } from '@/constants';

const formatJpMoney = (number) => {
    return new Intl.NumberFormat('ja-JP', { currency: 'JPY' }).format(number);
};

const appFormat = (value, formatType, locale) => {
    if (!value) return '';

    if (locale) {
        return moment(value).locale(locale).format(formatType);
    }

    return moment(value).format(formatType);
};

const appFormatHasCurrentFormatType = (value, currentFormatType, formatType, locale) => {
    if (!value) return '';

    if (locale) {
        return moment(value, currentFormatType).locale(locale).format(formatType);
    }

    return moment(value, currentFormatType).format(formatType);
};

const getNearestMinute = (number) => {
    const value = parseInt(number);

    if (value > 45) return '00';
    if (value > 30) return '45';
    if (value > 15) return '30';
    if (value > 0) return '15';

    return '00';
};

const removeSecondsFromTime = (time) => {
    if (time.length > 5) {
        return time.slice(0, -3);
    }
    return time;
};

const calcNearestTime = (distanceBetweenFromTimeAndToTime = Common.TIME_DISTANCE_DEFAULT) => {
    let toHour, toMinute;
    let date = moment().format(Common.DATE_FORMAT);
    let fromHour = moment().format(Common.HOUR_FORMAT);
    let fromMinute = getNearestMinute(moment().format(Common.MINUTE_FORMAT));
    const currentMinute = moment().format(Common.MINUTE_FORMAT);
    const minHour = splitTime(Common.TIME_MIN_IN_DAY).hours;
    const minMinute = splitTime(Common.TIME_MIN_IN_DAY).minutes;
    const maxHour = splitTime(Common.TIME_MAX_IN_DAY).hours;
    const maxMinute = splitTime(Common.TIME_MAX_IN_DAY).minutes;

    if (fromHour == maxHour) {
        if (currentMinute >= maxMinute || fromMinute >= maxMinute) { // next date if now > 23:30
            date = moment().add(1, 'days').format(Common.DATE_FORMAT);
            fromHour = minHour;
            fromMinute = minMinute;
        }
    } else {
        if (currentMinute >= maxMinute) { // next hour if currentMinute >= 45
            fromHour = moment().add(1, 'hours').format(Common.HOUR_FORMAT);
            fromMinute = minMinute;
        }
    }

    const toTime = calcToTimeInDay(parseTime(fromHour, fromMinute), distanceBetweenFromTimeAndToTime);
    toHour = toTime.toHour;
    toMinute = toTime.toMinute;

    return {
        date,
        fromHour,
        fromMinute,
        toHour,
        toMinute,
    };
};

const calcToTimeInDay = (fromTime, duration) => {
    let toHour, toMinute;
    const fromHour = splitTime(fromTime).hours;
    const fromMinute = splitTime(fromTime).minutes;
    const maxHour = splitTime(Common.TIME_MAX_IN_DAY).hours;
    const maxMinute = splitTime(Common.TIME_MAX_IN_DAY).minutes;
    const toDateTime = moment(parseTime(fromHour, fromMinute), Common.TIME_FORMAT).add(duration * 60, 'minutes').format(Common.FULL_DATE_TIME_FORMAT);
    const isToday = moment(toDateTime).isSame(moment().format(Common.DATE_FORMAT), 'day');

    toHour = moment(toDateTime).format(Common.HOUR_FORMAT);
    toMinute = moment(toDateTime).format(Common.MINUTE_FORMAT);

    if (!isToday) {
        toHour = maxHour;
        toMinute = maxMinute;
    }

    return {
        toHour,
        toMinute,
    };
};

const splitTime = (time) => {
    if (time === null || time === undefined) {
        return {
            hours: 0,
            minutes: 0,
            seconds: 0,
        };
    }
    const data = time.split(':');

    return { hours: data[0], minutes: data[1], seconds: data[2] };
};

const parseTime = (hour, minute) => {
    return hour + ':' + minute;
};
const parsePostcode = (postCode) => {
    if (postCode !== undefined && postCode.toString().length > 3) {
        return postCode?.substring(0, 3) + '-' + postCode?.substring(3, 7);
    }

    return postCode;
};

const activeHours = (hours, date, businessTimeFrom, businessTimeTo) => {
    const hourCurrent = moment().hours();
    const dateCurrent = moment().format(Common.DATE_FORMAT);
    businessTimeFrom = businessTimeFrom || Common.TIME_MIN_IN_DAY;
    businessTimeTo = businessTimeTo || Common.TIME_MAX_IN_DAY;
    let activeHours = [];
    (hours || []).forEach((hour) => {
        let isDisabled = false;
        if (appFormat(date, Common.DATE_FORMAT) === dateCurrent && hour?.value < hourCurrent) {
            isDisabled = true;
        }

        if (Number(hour?.value) < Number(splitTime(businessTimeFrom).hours) || Number(hour?.value) > Number(splitTime(businessTimeTo).hours)) {
            isDisabled = true;
        }

        activeHours.push({ ...hour, disabled: isDisabled });
    });
    return activeHours;
};

const getImageDefault = (path) => {
    if (path == '' || path === undefined || path === null) {
        return Common.IMAGES.NO_IMAGE;
    }
    return path;
};

const getDefaultBirthdayYear = () => {
    return Number(moment().format('Y')) - Number(Common.BIRTH_YEAR_AGE.DEFAULT);
};

const getBirthdayYears = () => {
    let years = [];
    const currentYear = Number(moment().format('Y'));
    const minYear = currentYear - Number(Common.BIRTH_YEAR_AGE.MIN);
    const maxYear = currentYear - Number(Common.BIRTH_YEAR_AGE.MAX);
    let i = maxYear;
    for (i; i <= minYear; i++) {
        years.push({
            value: i,
            label: i,
        });
    }

    years.push({
        value: '',
        label: '',
    });

    return years.reverse();
};

const isJson = (value) => {
    try {
        JSON.parse(value);
    } catch (e) {
        return false;
    }
    return true;
};

const convertData = (dataModal) => {
    for (const key in dataModal) {
        if (dataModal[key] === null) {
            dataModal[key] = '';
        }

        if (dataModal[key] === true || dataModal[key] === 'true') {
            dataModal[key] = Common.BOOLEAN.TRUE;
        }

        if (dataModal[key] === false || dataModal[key] === 'false') {
            dataModal[key] = Common.BOOLEAN.FALSE;
        }
    }
    return dataModal;
};

const convertTextToDot = (value) => {
    const character = '⬤';
    let newValue = '';
    for (let i = 0; i < value.length; i++) {
        newValue += character;
    }

    return newValue;
};

const isMultipleBytes = (str) => {
    if (!str) return false;

    return str.split('').length !== (new TextEncoder().encode(str)).length;
};

const calcDistanceTime = (timeFrom, timeTo) => {
    const currentDate = moment().format(Common.DATE_FORMAT);
    const fromDateTime = moment(appFormat(`${currentDate} ${timeFrom}`, Common.FULL_DATE_TIME_FORMAT_WITH_DASH)).set({ second: 0, millisecond: 0 });
    const toDateTime = moment(appFormat(`${currentDate} ${timeTo}`, Common.FULL_DATE_TIME_FORMAT_WITH_DASH)).set({ second: 0, millisecond: 0 });
    const differenceInMs = toDateTime.diff(fromDateTime); // diff yields milliseconds
    const duration = moment.duration(differenceInMs); // moment.duration accepts ms

    return duration.asHours();
};

const calcTax = (value, tax) => {
    const priceNum = Number(value),
        taxNum = Number(tax) || 0;
    let price = priceNum;

    if (taxNum > 0 && price > 0) {
        price = priceNum + (priceNum * taxNum);
    }

    return price;
};

const handleLocalStorageAfterLogout = () => {
    localStorage.removeItem(LocalStorageKey.USER_INFO);
    localStorage.removeItem(LocalStorageKey.LOGIN_AT);
    localStorage.removeItem(LocalStorageKey.PHONE_NUMBER);
};

export {
    formatJpMoney,
    appFormat,
    appFormatHasCurrentFormatType,
    getNearestMinute,
    removeSecondsFromTime,
    calcNearestTime,
    splitTime,
    parseTime,
    parsePostcode,
    activeHours,
    getImageDefault,
    getDefaultBirthdayYear,
    getBirthdayYears,
    isJson,
    convertData,
    convertTextToDot,
    isMultipleBytes,
    calcTax,
    calcDistanceTime,
    handleLocalStorageAfterLogout,
};
