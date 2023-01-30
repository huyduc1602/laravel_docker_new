import * as React from 'react';

import { NotFound, PublicRoute } from '@/components/common';
import { ForgotPassword, Login, ResetPassword } from '@/components/pages/Auth';
import { HomePage } from '@/components/pages/HomePage';
import AuthLayout from '@/components/pages/Layout/AuthLayout';
import GuestLayout from '@/components/pages/Layout/GuestLayout';
import { RoutePath } from '@/constants';

export function getRouteObjects(isAuthenticate = false) {
    return [
        {
            path: '/',
            element: <PublicRoute authenticate={isAuthenticate} />,
            children: [
                {
                    element: <AuthLayout />,
                    children: [
                        { path: RoutePath.AUTH.LOGIN, element: <Login authenticate={isAuthenticate} /> },
                    ],
                },
            ],
        },
        {
            path: '/',
            element: <PublicRoute />,
            children: [
                {
                    element: <AuthLayout />,
                    children: [
                        { path: RoutePath.AUTH.FORGOT_PASSWORD, element: <ForgotPassword /> },
                        { path: RoutePath.AUTH.RESET_PASSWORD, element: <ResetPassword /> },
                    ],
                },

            ],
        },
        {
            path: '/',
            element: <GuestLayout />,
            children: [
                { index: true, element: <HomePage /> },
            ],
        },
        {
            path: '*',
            element: <NotFound />,
        },
    ];
}
