<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Services\NewsServiceImp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    protected NewsServiceImp $newsService;

    public function __construct(NewsServiceImp $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        if (Auth::check()) {
            return view('news.news');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show News
     */
    public function show($id)
    {
        $news = $this->newsService->findOne($id);
        return ($news) ? response()->json([
            'status' => config('constants.STATUS_OK'),
            'news' => $news,
        ]) : response()->json([
            'status' => config('constants.STATUS_NOT_FOUND'),
            'msg' => 'Not Found',
        ]);
    }

    public function getRecords()
    {
        $html = null;
        $news = $this->newsService->getAllWithPagination(6);
        $html = view('news.response', compact('news'))->render();
        if ($html !== null) {
            return response()->json([
                'status' => config('constants.STATUS_OK'),
                'record' => $html,
            ]);
        } else {
            return response()->json([
                'status' => config('constants.STATUS_FORBIDDEN'),
                'msg' => "Can't verify user's permission",
            ]);
        }
    }

    public function search(Request $request)
    {
        if ($request->isMethod('get')) {
            $collection = collect($request->all());
            $hasKeyword = $collection->contains(function ($value, $key) {
                return $key == 'keyword';
            });

            $hasDateStart = $collection->contains(function ($value, $key) {
                return $key == 'dateStart';
            });

            $hasDateEnd = $collection->contains(function ($value, $key) {
                return $key == 'dateEnd';
            });

            if ($hasKeyword && $hasDateStart && $hasDateEnd) {
                $news = $this->newsService->getNewsBetween2DayWithKeyword($collection->get('keyword'),
                    $collection->get('dateStart'), $collection->get('dateEnd'));
            } else {
                if ($hasKeyword) {
                    $news = $this->newsService->getNewsByKeyword($collection->get('keyword'));
                } else {
                    if ($hasDateStart && $hasDateEnd) {
                        $news = $this->newsService->getNewsBetween2Day($collection->get('dateStart'),
                            $collection->get('dateEnd'));
                    }
                }
            }

            if (empty($news)) {
                return response()->json([
                    'status' => config('constants.STATUS_NOT_FOUND'),
                    'msg' => "Not Found",
                ]);
            }
            $html = view('news.response', compact('news'))->render();

            return response()->json([
                'status' => config('constants.STATUS_OK'),
                'record' => $html,
            ]);
        } else {
            return response()->json([
                'status' => config('constants.STATUS_BAD_REQUEST'),
                'msg' => "This function just support for GET method",
            ]);
        }
    }

    public function update($id, NewsRequest $request)
    {
        $News = $this->newsService->findOne($id);
        if ($News) {
            $attributes = $request->only(['title', 'release_date', 'information', 'url']);
            $updateNews = $this->newsService->update($id, $attributes);

            if ($updateNews) {
                return response()->json([
                    'status' => config('constants.STATUS_CREATED'),
                    'msg' => 'Update successfully',
                ]);
            } else {
                return response()->json([
                    'status' => config('constants.STATUS_INTERNAL_SERVER_ERROR'),
                    'msg' => "Can't update this news"
                ]);
            }
        } else {
            return response()->json([
                'status' => config('constants.STATUS_NOT_FOUND'),
                'msg' => "Not Found News with id : {$id}"
            ]);
        }
    }

    public function create(NewsRequest $request)
    {
        $attributes = $request->all();
        $createNews = $this->newsService->create($attributes);

        if ($createNews) {
            return response()->json([
                'status' => config('constants.STATUS_OK'),
                'news' => $createNews,
                'msg' => 'Create successfully',
            ]);
        } else {
            return response()->json([
                'status' => config('constants.STATUS_INTERNAL_SERVER_ERROR'),
                'msg' => "Can't create this news"
            ]);
        }
    }

    public function delete($id)
    {
        $isSuccess = $this->newsService->delete($id);
        if ($isSuccess) {
            return response()->json([
                'status' => config('constants.STATUS_OK'),
                'msg' => 'Deleted Success'
            ]);
        } else {
            return response()->json([
                'status' => config('constants.STATUS_INTERNAL_SERVER_ERROR'),
                'msg' => "Can't remove this news"
            ]);
        }
    }
}
