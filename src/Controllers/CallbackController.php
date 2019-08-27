<?php

namespace Newsletter2Go\Controllers;

use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;

class CallbackController extends Controller
{

    /**
     * @var ConfigRepository
     */
    private $configRepository;


    /**
     * ApiController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function callback(Request $request)
    {
        $companyId = $request->get('company_id');
        if(isset($companyId)){
            $this->configRepository->set('newsletter2go.company_id', $companyId);

            return ['success' => true, 'message' => 'OK'];
        } else {

            return ['success' => false, 'message' => 'Missing parameter company_id.'];
        }
    }
}