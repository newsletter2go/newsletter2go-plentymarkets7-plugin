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
        $formButton = $widgetSettings["formAppearance"]["mobile"];
        $formNumber = mt_rand (0, 999);

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
                    "formButton" => $formButton,
                    "randomString" => $formNumber
                ]
            ];
        }
    }
}
