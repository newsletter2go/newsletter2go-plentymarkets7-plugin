<?php

namespace Newsletter2Go\Widgets;

use Ceres\Widgets\Helper\BaseWidget;

class FormWidget extends BaseWidget
{
    protected $template = "Newsletter2Go::Widgets.FormWidget";

    protected function getTemplateData($widgetSettings, $isPreview)
    {
        $formTitle = $widgetSettings["formTitle"]["mobile"];
        $formKey = $widgetSettings["formKey"]["mobile"];

        if (empty($formKey))
        {
            return [
                "formInfo" => false
            ];
        }else {
            return [
                "formInfo" => [
                    "formTitle" => $formTitle,
                    "formKey" => $formKey,
                ]
            ];
        }
    }
}
