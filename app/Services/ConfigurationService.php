<?php

namespace App\Services;

use App\Models\Configuration;

class ConfigurationService
{
    public function getEventConfiguration()
    {
        return Configuration::first();
    }
}
