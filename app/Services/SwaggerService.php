<?php

namespace App\Services;

use App\Common\Constant;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as RequestFacade;
use L5Swagger\GeneratorFactory;

class SwaggerService
{
    /**
     * @param Request $request
     * @param string|null $apiType
     * @return array
     */
    public function api(Request $request, string $apiType = null): array
    {
        $documentation = $request->offsetGet('documentation');
        $config = $request->offsetGet('config');
        $config['paths']['docs_yaml'] = 'user-docs.yaml';
        if ($apiType == 'admin') {
            $config['paths']['docs_yaml'] = 'admin-docs.yaml';
        }

        if ($proxy = $config['proxy']) {
            if (!is_array($proxy)) {
                $proxy = [$proxy];
            }
            Request::setTrustedProxies($proxy, Constant::REQUEST_HEADER_X_FORWARDED_ALL);
        }

        $urlToDocs = $this->generateDocumentationFileURL($documentation, $config);
        $useAbsolutePath = config('l5-swagger.documentations.' . $documentation . '.paths.use_absolute_path', true);

        // Need the / at the end to avoid CORS errors on Homestead systems.
        return [
            'documentation'    => $documentation,
            'secure'           => RequestFacade::secure(),
            'urlToDocs'        => $urlToDocs,
            'operationsSorter' => $config['operations_sort'],
            'configUrl'        => $config['additional_config_url'],
            'validatorUrl'     => $config['validator_url'],
            'useAbsolutePath'  => $useAbsolutePath,
        ];
    }

    /**
     * Dump api-docs content endpoint. Supports dumping a json, or yaml file.
     *
     * @param Request $request
     * @param GeneratorFactory $generatorFactory
     * @param string|null $folder
     * @param string|null $file
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \L5Swagger\Exceptions\L5SwaggerException
     */
    public function docs(Request $request, GeneratorFactory $generatorFactory, string $folder = null, string $file = null): array
    {
        $fileSystem = new Filesystem();
        $documentation = $request->offsetGet('documentation');
        $config = $request->offsetGet('config');
        $targetFile = $config['paths']['docs_json'] ?? 'api-docs.json';
        $yaml = false;

        if ($file !== null) {
            $targetFile = "{$folder}/{$file}";
            $parts = explode('.', $file);
            if (!empty($parts)) {
                $extension = array_pop($parts);
                $yaml = strtolower($extension) === 'yaml';
            }
        }

        $filePath = $config['paths']['docs'] . '/' . $targetFile;
        if ($config['generate_always']) {
            $generator = $generatorFactory->make($documentation);

            try {
                $generator->generateDocs();
            } catch (\Exception $e) {
                Log::error($e);
                abort(404, sprintf(
                        'Unable to generate documentation file to: "%s". Please make sure directory is writable. Error: %s',
                        $filePath,
                        $e->getMessage())
                );
            }
        }

        if (!$fileSystem->exists($filePath)) {
            abort(404, sprintf('Unable to locate documentation file at: "%s"', $filePath));
        }

        $content = $fileSystem->get($filePath);
        if ($yaml) {
            return ['content' => $content, 'headers' => [
                'Content-Type' => 'application/yaml', 'Content-Disposition' => 'inline'
            ]];
        }

        return ['content' => $content, 'headers' => ['Content-Type' => 'application/json']];
    }

    /**
     * Generate URL for documentation file.
     *
     * @param string $documentation
     * @param array $config
     * @return string
     */
    protected function generateDocumentationFileURL(string $documentation, array $config): string
    {
        $fileUsedForDocs = $config['paths']['docs_json'] ?? 'api-docs.json';
        if (!empty($config['paths']['format_to_use_for_docs'])
            && $config['paths']['format_to_use_for_docs'] === 'yaml'
            && $config['paths']['docs_yaml']
        ) {
            $fileUsedForDocs = $config['paths']['docs_yaml'];
        }

        $useAbsolutePath = config('l5-swagger.documentations.' . $documentation . '.paths.use_absolute_path', true);

        return route('l5-swagger.' . $documentation . '.docs', $fileUsedForDocs, $useAbsolutePath);
    }
}
