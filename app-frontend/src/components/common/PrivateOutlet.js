import { LocalStorageKey, RoutePath } from '@/constants';
import PropTypes from 'prop-types';
import { useDispatch, useSelector } from 'react-redux';
import { Navigate, Outlet, useLocation } from 'react-router-dom';
import { showPopupAlert } from '@/slices/appSlice';
import { useAppTranslation } from '@/hooks';

const PrivateOutlet = ({ authenticate, roles = [] }) => {
    const dispatch = useDispatch();
    const location = useLocation();
    const isLogout = localStorage.getItem(LocalStorageKey.LOGOUT_FLAG) || false;
    const { user } = useSelector(state => state.auth);
    const userHasRequiredRole = roles.includes(user?.info?.roleId);
    const { tCommon } = useAppTranslation();
    const message = tCommon('message.code.AMSG00004');

    if (!authenticate) {
        return <Navigate to={RoutePath.AUTH.LOGIN} state={{ redirect_to: isLogout ? RoutePath.HOME : location.pathname }} />;
    }

    if (authenticate && !userHasRequiredRole) {
        dispatch(showPopupAlert({
            type: 'error',
            message: message,
        }));
        return <Navigate to={RoutePath.NOT_FOUND} state={{ message: message }} />;
    }

    return <Outlet />;
};

PrivateOutlet.propTypes = {
    authenticate: PropTypes.bool,
    roles: PropTypes.array,
};

export default PrivateOutlet;