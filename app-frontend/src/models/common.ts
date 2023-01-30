export interface Paginate {
    total: number,
    perPage: number,
    currentPage: number,
    totalPages: number,
    from: number,
    to: number,
}
export interface ResponseSuccess {
    status: number,
    message: string,
}

export interface SearchParams<T> {
    filter: T,
    perPage?: number,
    page?: number,
}

export interface ResourcePaginate<T> extends Paginate {
    data: Array<T>
}