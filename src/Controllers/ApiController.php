<?php

namespace Newsletter2Go\Controllers;

use Newsletter2Go\Helpers\Data;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;

class ApiController extends Controller
{
    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * ApiController constructor.
     *
     * @param Data $dataHelper
     */
    public function __construct(Data $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return array
     */
    public function test()
    {
        return ['test' => true, 'success' => true, 'message' => publicPath('Newsletter2Go')];
    }

    /**
     * @return array
     */
    public function version()
    {
        return ['data' => '4.0.00', 'success' => true];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function customerCount(Request $request)
    {
        try {
            $contacts = $this->customers($request);
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        return ['data' => count($contacts), 'success' => true];
    }

    /**
     * Returns all customers on the system
     *
     * @param Request $request
     *
     * @return array
     */
    public function customers(Request $request)
    {
        $subscribed = filter_var(
            $request->get('newsletterSubscribersOnly', false),
            FILTER_VALIDATE_BOOLEAN
        );
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 50);
        $hours = $request->get('hours', 0);
        $emails = $request->get('emails', []);
        $group = $request->get('group');

        if (!is_numeric($hours)) {
            return ['success' => false, 'message' => 'Hours parameter must be numeric value.'];
        } else {
            $hours = intval($hours);
        }

        if (!isset($group)) {
            return ['success' => false, 'message' => 'Group parameter is required.'];
        }

        if (strpos($group, 'newsletter_') === 0) {
            $group = str_replace('newsletter_', '', $group);

            return $this->dataHelper->getRecipients(intval($group), $subscribed, $hours, $emails);
        } else {
            return $this->dataHelper->getContacts(intval($group), $subscribed, $hours, $emails, $page, $limit);
        }
    }

}
