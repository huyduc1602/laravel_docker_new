<?php

namespace App\Repositories;

class NewsRepository extends BaseRepository
{

    public function getModel(): string
    {
        return \App\Models\News::class;
    }

    public function getNewsBetween2Day($DateStart, $DateEnd)
    {
        return $this->_model->where('login_display_flg', 1)->whereBetween('release_date',
            [$DateStart, $DateEnd])->orderBy('release_date', 'DESC')->get();
    }
}
