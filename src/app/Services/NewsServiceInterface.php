<?php

namespace App\Services;

interface NewsServiceInterface
{
    public function getNewsOf30Days();
    public function getAllWithPagination();
    public function getNewsByKeyword($keyword);
    public function getNewsBetween2Day($dateStart, $dateEnd);
    public function getNewsBetween2DayWithKeyword($keyword, $dateStart, $dateEnd);
}
