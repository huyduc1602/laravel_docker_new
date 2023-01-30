import { ResponseSuccess } from '@/models/common';
import { UserProfile, VerifyPasswordParam } from '@/models/users/Profile';
import axiosClient from './axiosClient';

const userApi = {
    fetchUserProfile: (): Promise<UserProfile> => {
        return axiosClient.get('/me');
    },
    updateUser: (userProfile: UserProfile): Promise<ResponseSuccess> => {
        return axiosClient.put('/me', userProfile);
    },
    verifyPassword: (param: VerifyPasswordParam): Promise<ResponseSuccess> => {
        return axiosClient.post('/me/confirm-password', param);
    },
};

export default userApi;