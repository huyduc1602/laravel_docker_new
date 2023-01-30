import { HttpStatus, RoutePath } from '@/constants';
import { clearSearchCondition, setErrorMessage, showPopupAlert } from "@/slices/appSlice";
import { logout } from '@/slices/authSlice';
import type { AppDispatch } from '@/store';
import { FieldValues, UseFormSetValue } from 'react-hook-form';
import { useDispatch } from 'react-redux';
import { useLocation, useNavigate } from "react-router-dom";

const useAppHandleMessage = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const useAppDispatch = () => useDispatch<AppDispatch>();
    const dispatch = useAppDispatch();

    //Type2 for case data return like:
    /*-------------------------------
    data: {errors: false
    message: "Message content"
    status: 200}
    -------------------------------*/
    const handleSuccess = (response: any, onSuccessActions?: Function, type2: Boolean = false) => {
        if (response?.status === HttpStatus.SUCCESS) {
            dispatch(showPopupAlert({
                type: 'success',
                message: type2 ? response?.data?.data?.message : response?.data?.message
            }));
        };

        if (onSuccessActions !== undefined && onSuccessActions !== null) onSuccessActions();
    }

    const handleLogout = async () => {
        // Dispatch redux logout and clear search condition
        await dispatch(logout());
        await dispatch(clearSearchCondition());

        // Redirect to homepage after login
        navigate(RoutePath.AUTH.LOGIN, { state: { redirect_to: RoutePath.HOME } });
    }

    const handleError = (error: any, formSetValue = null as UseFormSetValue<FieldValues>, redirectPath: string = '') => {
        const message = error?.data?.message;
        const redirectPage = () => {
            if (redirectPath !== '') {
                return navigate(redirectPath);
            }
        }

        switch (error?.status) {
            case HttpStatus.UNAUTHORIZED:
            case HttpStatus.FORBIDDEN:
                dispatch(setErrorMessage(message));
                dispatch(showPopupAlert({
                    type: 'error',
                    message: message,
                }));
                handleLogout();
                break;
            case HttpStatus.UNPROCESSABLE_CONTENT:
                if (formSetValue !== null) {
                    const dataErrors = error.data;
                    Object.entries(dataErrors.errors).forEach((entry: any) => {
                        const [key, value] = entry;
                        formSetValue(key, { message: value[0] });
                    });
                }

                break;
            case HttpStatus.NOT_FOUND:
                if (redirectPath !== '') {
                    dispatch(showPopupAlert({
                        type: 'error',
                        message: message,
                    }));
                    navigate(redirectPath);
                } else {
                    navigate(RoutePath.NOT_FOUND);
                }
                break;
            case HttpStatus.BAD_REQUEST:
            case HttpStatus.SERVER_ERROR:
            case HttpStatus.NOT_ACCEPTABLE:
                dispatch(showPopupAlert({
                    type: 'error',
                    message: message,
                }))
                break;
            case HttpStatus.CONFLICT:
                dispatch(showPopupAlert({
                    type: 'error',
                    message: message,
                }));

                redirectPage();
                break;
            default:
                break;
        }
    }

    return {
        handleError,
        handleSuccess,
    }
}

export default useAppHandleMessage;