<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\News;

class NewsRepository extends BaseRepository{
    public function getModel(){
        return News::class;
    }
    
}