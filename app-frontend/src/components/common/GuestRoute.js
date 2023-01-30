import { RoutePath } from '@/constants';
import PropTypes from 'prop-types';
import { useSelector } from 'react-redux';
import { Navigate, Outlet } from 'react-router-dom';

const GuestRoute = ({ authenticate }) => {
    const { isRedirectPage } = useSelector(state => state.auth);
    if (authenticate && isRedirectPage) {
        return <Navigate to={RoutePath.HOME} />;
    }
    return <Outlet />;
};

GuestRoute.propTypes = {
    authenticate: PropTypes.bool,
};

export default GuestRoute;