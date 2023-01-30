import React, { useEffect, useState } from 'react';
import { HttpStatus, RoutePath } from '@/constants';
import { useAppTranslation } from '@/hooks';
import { Link, useLocation } from 'react-router-dom';
import logo from '@/assets/img/comolu_logo_vert.svg';

export const NotFound = () => {
    const { tCommon } = useAppTranslation();
    const [messageError, setMessageError] = useState(null);
    const location = useLocation();

    useEffect(() => {
        if(location?.state !== null) {
            setMessageError(location?.state?.message);
        }
    }, []);

    return (
        <>
            <div id="wrapper" className="notFound">
                <div className="inner">
                    <img src={logo} alt={tCommon('app_name')} />
                    <h2>{HttpStatus.NOT_FOUND}</h2>
                    <h4>{tCommon('not_found.message_1')}</h4>
                    <p>{messageError !== null ? <span dangerouslySetInnerHTML={{__html: messageError }} /> : tCommon('not_found.message_2')}</p>
                    <Link to={RoutePath.HOME} className="btn btn--primary mt20">トップページに戻る</Link>
                </div>
            </div>
        </>
    );
};