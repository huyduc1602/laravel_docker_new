const RoutePath = {
    HOME: '/',
    AUTH: {
        LOGIN: '/login',
        FORGOT_PASSWORD: '/forgot-password',
        RESET_PASSWORD: '/reset-password/:token',
        REGISTER: '/register',
    },
    ME: {
        CARDS_MANAGER: '/me/cards',
        CARDS_REGISTER: '/me/cards/register',
    },
    ABOUT: '/about',
    CONTACT: {
        INDEX: '/contact-us/',
        THANKS: '/contact-us/thanks',
    },
    COMPANY_REGISTER: {
        INDEX: '/company-request/',
    },
    PROFILE: '/profile',
    NOT_FOUND: '/404',
};

export default RoutePath;
