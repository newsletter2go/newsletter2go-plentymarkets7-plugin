<?php

namespace GoogleMapsWidget\Widgets;
use Ceres\Widgets\Helper\BaseWidget;

class MapsWidget extends BaseWidget
{
    protected $template = "GoogleMapsWidget::Widgets.MapsWidget";
    protected function getTemplateData($widgetSettings, $isPreview)
    {
        $source = $widgetSettings["source"]["mobile"];
        $height = $widgetSettings["height"]["mobile"];
        $width = $widgetSettings["width"]["mobile"];

        if (empty($source))
        {
            return [
                "iframeurl" => false
            ];
        }
        return [
            "source" => $source,
            "width" => $width,
            "height" => $height
        ];
    }
}