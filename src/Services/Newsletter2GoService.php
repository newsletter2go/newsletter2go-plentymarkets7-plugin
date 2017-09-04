<?php

namespace Newsletter2Go\Services;

use IO\Services\WebstoreConfigurationService;
use IO\Helper\TemplateContainer;

/**
 * Class Newsletter2GoService
 * @package Newsletter2Go\Services
 */
class Newsletter2GoService
{
    public function getShopUrl() {
        /** @var WebstoreConfigurationService $webstoreConfig */
        $webstoreConfig = pluginApp(WebstoreConfigurationService::class);
        $storeConf = $webstoreConfig->getWebstoreConfig()->toArray();

        return $storeConf['domainSsl'];
    }

    public function getTemplate() {
        /** @var TemplateContainer $templateContainer */
        $templateContainer = pluginApp(TemplateContainer::class);
        $storeConf = $templateContainer->getTemplate();

        return $storeConf['domainSsl'];
    }
}
