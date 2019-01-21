<?php

namespace Newsletter2Go\Widgets;

use Ceres\Widgets\Helper\BaseWidget;

class FormWidget extends BaseWidget
{
    protected $template = "Newsletter2Go::Widgets.FormWidget";

    protected function getTemplateData($widgetSettings, $isPreview)
    {
        $formKey = $widgetSettings["formKey"]["mobile"];
        $formConfig = $widgetSettings["formConfig"]["mobile"];

        if (empty($formKey))
        {
            return [
                "formCode" => false
            ];
        }else {
            return [
                "formCode" => [
                    "formKey" => $formKey,
                    "formConfig" => $formConfig
                ]
            ];
        }
    }
}
