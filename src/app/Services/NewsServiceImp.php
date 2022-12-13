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
        return $this->newsRepository->findOne($id);
    }

    public function getAll()
    {
        return $this->newsRepository->getAll();
    }

    public function create($data)
    {
        return $this->newsRepository->create($data);
    }

    public function delete($id)
    {
        $news = $this->newsRepository->delete($id);
    }

    public function update($id, $data): bool
    {
        return $this->newsRepository->update($id, $data);
    }

    public function getNewsOf30Days()
    {
        $today = strtotime(now());
        $After30Days = strtotime('+ 30 day', $today);
        return $this->newsRepository->getNewsBetween2Day($today, $After30Days);
    }
}
