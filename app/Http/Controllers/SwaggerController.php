<?php

namespace App\Http\Controllers;

use L5Swagger\Http\Controllers\SwaggerController as BaseSwaggerController;
use L5Swagger\GeneratorFactory;
use App\Services\SwaggerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class SwaggerController extends BaseSwaggerController
{
    /**
     * @var SwaggerService
     */
    private $swaggerService;

    /**
     * @param GeneratorFactory $generatorFactory
     * @param SwaggerService $swaggerService
     */
    public function __construct(GeneratorFactory $generatorFactory, SwaggerService $swaggerService)
    {
        parent::__construct($generatorFactory);

        $this->swaggerService = $swaggerService;
    }

    /**
     * Display Swagger API page.
     *
     * @param Request $request
     * @param string|null $apiType
     * @return Response
     */
    public function api(Request $request, string $apiType = null)
    {
        $result = $this->swaggerService->api($request, $apiType);

        // Need the / at the end to avoid CORS errors on Homestead systems.
        return ResponseFacade::make(view('l5-swagger::index', $result));
    }

    /**
     * Dump api-docs content endpoint. Supports dumping a json, or yaml file.
     *
     * @param Request $request
     * @param string|null $folder
     * @param string|null $file
     * @return Response
     */
    public function docs(Request $request, string $folder = null, string $file = null)
    {
        $result = $this->swaggerService->docs($request, $this->generatorFactory, $folder, $file);

        return ResponseFacade::make($result['content'], 200, $result['headers']);
    }
}
