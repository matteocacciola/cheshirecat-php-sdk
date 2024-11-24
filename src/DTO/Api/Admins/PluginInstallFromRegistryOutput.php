<?php

namespace DataMat\CheshireCat\DTO\Api\Admins;

use DataMat\CheshireCat\DTO\Api\Plugin\PluginToggleOutput;

class PluginInstallFromRegistryOutput extends PluginToggleOutput
{
    public string $url;

    public string $info;
}