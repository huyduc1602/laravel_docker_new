<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Services\NewsServiceInterface;

class NewsServiceImp implements NewsServiceInterface {

    public function __construct(NewsRepository $newsRepository){
        $this->newsRepository = $newsRepository;
    }

    public function findOne($id) {
        $news = $this->newsRepository->findOne($id);
        return $news;
    }

    public function getAll() {
        $news = $this->newsRepository->findAll();
        return $news;
    }

    public function create($data) {
        $news = $this->newsRepository->create($data);
        return $news;
    }

    public function delete($id) {
        $news = $this->newsRepository->delete($id);
    }

    public function update($id, $data) {
        $news = $this->newsRepository->update($id, $data);
        return $news;
    }

    public function getNewsOf30Days() {
        $today = strtotime(now());
        $After30Days = strtotime('+ 30 day', $today);
        $news = $this->newsRepository->getNewsBetween2Day($today, $After30Days);
        return $news;
    }
}
