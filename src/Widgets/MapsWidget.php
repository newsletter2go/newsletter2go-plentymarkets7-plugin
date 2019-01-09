<?php

namespace Newsletter2Go\Widgets;

use Ceres\Widgets\Helper\BaseWidget;

class MapsWidget extends BaseWidget
{
    protected $template = "Newsletter2Go::Widgets.MapsWidget";

    protected function getTemplateData($widgetSettings, $isPreview)
    {
        $apiKey = $widgetSettings["apiKey"]["mobile"];

        if (empty($apiKey))
        {
            return [
                "geocoding_data" => false
            ];
        }

        if ($apiKey)
        {
            return [
                "geocoding_data" => [
                    "apiKey" => $apiKey
                ]
            ];
        }

        return [
            "geocoding_data" => false
        ];
    }
}
