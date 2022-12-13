<?php

namespace App\Http\Controllers;

use App\Services\implements\NewsServiceImp;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    protected $newsService = new NewsService();

    public function __construct(NewsServiceImp $newsService){
        $this->newsService = $newsService;
    }

    /**
     * Show News
     */
    public function show($id) {
        $news = $this->$newsService->findOne($id);
        return ($news) ? response()->json([
            'status' => 200,
            'news' => $news,
        ]) : response()->json([
            'status' => 404,
            'msg' => 'Not Found',
        ]);
    }
}
