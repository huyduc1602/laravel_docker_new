import { useRoutes } from 'react-router-dom';
import { getRouteObjects } from './WebRoute';

const useAppRoutes = () => {
    const webRouteObjects = (isAuthenticate) => {
        return useRoutes(getRouteObjects(isAuthenticate));
    };
    return {
        webRouteObjects,
    };
};

export default useAppRoutes;