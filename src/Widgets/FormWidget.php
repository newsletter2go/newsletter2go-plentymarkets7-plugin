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
        $formConfig = $widgetSettings["formConfig"]["mobile"];

        if(!isset($formConfig)){
            $formConfig = '{"container": {"type": "div","class": "","style": ""},"row": {"type": "div","class": "","style": "margin-top: 15px;"},"columnLeft": {"type": "div","class": "","style": ""},"columnRight": {"type": "div","class": "","style": ""},"button": {"type": "button","style": "background-color: #000000;"},"label": {"type": "label","class": "","style": ""}}';
        }

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
                    "formConfig" => $formConfig
                ]
            ];
        }
    }
}
