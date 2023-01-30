<?php

namespace App\Services;

use App\Repositories\NewsRepository;

class NewsServiceImp implements NewsServiceInterface
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function findOne($id)
    {
        $News = $this->newsRepository->findOne($id);
        if ($News) {
            return $News;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $ListNews = $this->newsRepository->getAll();
        if ($ListNews) {
            return $ListNews;
        } else {
            return false;
        }
    }

    public function create($data)
    {
        $News = $this->newsRepository->create($data);
        if ($News) {
            return $News;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $isSuccess = $this->newsRepository->delete($id);
        if ($isSuccess) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $data)
    {
        return $this->newsRepository->update($id, $data);
    }

    public function getNewsOf30Days()
    {
        $today = now()->toDate()->format('Y-m-d');
        $afterNumberOfDays = now()->addDay(config('constants.NUMBER_OF_DAY_BETWEEN'))->toDate()->format('Y-m-d');
        $ListNews = $this->newsRepository->getNewsBetween2Day($today, $afterNumberOfDays);
        if ($ListNews) {
            return $ListNews;
        }
        return false;
    }

    public function getAllWithPagination()
    {
        $ListNews = $this->newsRepository->getAllWithPagination();
        if ($ListNews) {
            return $ListNews;
        }
        return false;
    }

    public function getNewsBetween2DayWithKeyword($keyword, $dateStart, $dateEnd)
    {
        $ListNews = $this->newsRepository->getNewsBetween2DayWithKeyword($keyword, $dateStart, $dateEnd);
        if ($ListNews) {
            return $ListNews;
        }
        return false;
    }

    public function getNewsByKeyword($keyword)
    {
        $ListNews = $this->newsRepository->getNewsByKeyword($keyword);
        if ($ListNews) {
            return $ListNews;
        }
        return false;
    }

    public function getNewsBetween2Day($dateStart, $dateEnd)
    {
        $ListNews = $this->newsRepository->getNewsBetween2Day($dateStart, $dateEnd);
        if ($ListNews) {
            return $ListNews;
        }
        return false;
    }
}
