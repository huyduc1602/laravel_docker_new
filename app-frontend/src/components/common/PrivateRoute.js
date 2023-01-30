import { LocalStorageKey, RoutePath } from '@/constants';
import React from 'react';
import { Navigate, useLocation } from 'react-router-dom';
import PropTypes from 'prop-types';

const PrivateRoute = ({ children, authenticate }) => {
    const location = useLocation();
    const isLogout = localStorage.getItem(LocalStorageKey.LOGOUT_FLAG) || false;

    if (!authenticate) {
        return <Navigate to={RoutePath.AUTH.LOGIN} state={{ redirect_to: isLogout ? RoutePath.HOME : location.pathname }} />;
    }

    return children;
};

PrivateRoute.propTypes = {
    children: PropTypes.node,
    authenticate: PropTypes.bool,
};

export default PrivateRoute;