<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;

class ConfigurationController extends Controller
{
    public function __construct(private readonly ConfigurationService $configurationService)
    {
    }

    public function getEventConfiguration()
    {
        $configuration = $this->configurationService->getEventConfiguration();

        return response()->json([
            'configuration' => $configuration,
        ]);
    }
}
