<?php

namespace App\Repositories;

class NewsRepository extends BaseRepository
{

    public function getModel(): string
    {
        return \App\Models\News::class;
    }

    public function getAllWithPagination(){
        return $this->_model->orderBy('release_date','desc')->paginate(config('constants.PAGINATION_NUMBER'));
    }

    public function getNewsBetween2Day($dateStart, $dateEnd)
    {
        return $this->_model->where('login_display_flg', 0)->where('del_flg', 0)->whereBetween('release_date',
            [$dateStart, $dateEnd])->orderBy('release_date','desc')->paginate(config('constants.PAGINATION_NUMBER'));
    }

    public function getNewsByKeyword($keyword)
    {
        return $this->_model->where('del_flg', 0)->where('title','LIKE',"%{$keyword}%")
            ->orderBy('release_date','desc')->paginate(config('constants.PAGINATION_NUMBER'));
    }

    public function getNewsBetween2DayWithKeyword($keyword,$dateStart, $dateEnd)
    {
        return $this->_model->where('del_flg', 0)->whereBetween('release_date',
            [$dateStart, $dateEnd])->orderBy('release_date', 'DESC')->where('title','LIKE',"%{$keyword}%")
            ->orderBy('release_date','desc')->paginate(config('constants.PAGINATION_NUMBER'));
    }
}
