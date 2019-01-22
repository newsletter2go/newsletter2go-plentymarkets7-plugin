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
        $formTitle = $widgetSettings["formTitle"]["mobile"];

        if (empty($formKey))
        {
            return [
                "formInfo" => false
            ];
        }else {
            return [
                "formInfo" => [
                    "formKey" => $formKey,
                    "formConfig" => $formConfig,
                    "formTitle" => $formTitle
                ]
            ];
        }
    }
}
