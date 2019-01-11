<?php

namespace Newsletter2Go\Widgets;

use Ceres\Widgets\Helper\BaseWidget;

class MapsWidget extends BaseWidget
{
    protected $template = "Newsletter2Go::Widgets.MapsWidget";

    protected function getTemplateData($widgetSettings, $isPreview)
    {
        $formKey = $widgetSettings["formKey"]["mobile"];

        if (empty($formKey))
        {
            return [
                "formCode" => false
            ];
        }else {

            return [
                "formCode" => [
                    "formKey" => $formKey
                ]
            ];
        }
    }
}
