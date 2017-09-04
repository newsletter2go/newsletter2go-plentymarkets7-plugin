<?php

namespace Newsletter2Go\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Response;
use Plenty\Plugin\Http\Request;

class ApiController extends Controller
{
    /**
     * @var string
     */
    protected $transaction;

    /**
     * @var null|Response
     */
    private $response;

    /**
     * @var Response
     */
    private $request;

    /**
     * @var  array
     */
    private $createOrderResult = [];

    public function __construct(
        Response $response,
        Request $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Retrieves all request params and authenticates user
     *
     * @param Request $request
     * @return array
     *
     */
    public function export(Request $request)
    {
        $this->createOrderResult['test'] = 'works';
        return $this->createOrderResult;
    }
}
