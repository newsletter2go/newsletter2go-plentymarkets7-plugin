<?php

namespace Newsletter2Go\Models;

use Plenty\Plugin\Application;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Processor\DocumentProcessor;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Search\Document\DocumentSearch;

use IO\Services\WebstoreConfigurationService;

class ExportModel
{
    /**
     * @var Application
     */
    private $app;

    /**
     * ExportModel constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

}
