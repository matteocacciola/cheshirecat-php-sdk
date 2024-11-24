<?php

namespace DataMat\CheshireCat\DTO\Api\Admins;

use DataMat\CheshireCat\DTO\Api\Plugin\PluginToggleOutput;

class PluginInstallOutput extends PluginToggleOutput
{
    public string $filename;
    public string $contentType;
}