export interface UserProfile {
    id: number,
    lastName: string,
    firstName: string,
    email: string,
    birthday: string,
    gender: string,
    phoneNumber?: string,
}

export interface VerifyPasswordParam {
    password: string
}
