<?php

namespace Newsletter2Go\Controllers;

use Newsletter2Go\Helpers\Data;
use Plenty\Modules\Account\Contact\Contracts\ContactRepositoryContract;
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
        return ['data' => '1.0.0', 'success' => true];
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
        $newsletterSubscribersOnly = filter_var(
            $request->get('newsletterSubscribersOnly', false),
            FILTER_VALIDATE_BOOLEAN
        );
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 50);
        $hours = $request->get('hours', 0);
        $emails = $request->get('emails', []);
        $groups = $request->get('groups', []);
        $fields = $request->get('fields', ['*']);

        if (!is_numeric($hours)) {
            return ['success' => false, 'message' => 'Hours parameter must be numeric value.'];
        }

        /** @var ContactRepositoryContract $contactRepository */
        $contactRepository = pluginApp(ContactRepositoryContract::class);
        $contacts = $contactRepository->getContactList([], [], $fields, $page, $limit)->getResult();
        $filteredContacts = [];

        foreach ($contacts as $contact) {
            if (!$this->dataHelper->checkEmailDomain($contact['email'])) {
                continue;
            }

            if ($hours && !$this->dataHelper->checkHours($contact, $hours)) {
                continue;
            }

            if (!empty($emails) && !in_array($contact['email'], $emails)) {
                continue;
            }

            if (!empty($groups) && !in_array($contact['classId'], $groups)) {
                continue;
            }

            if ($newsletterSubscribersOnly && $contact['newsletterAllowanceAt'] === null) {
                continue;
            }

            $filteredContacts[] = $contact;
        }

        return $filteredContacts;
    }

}
