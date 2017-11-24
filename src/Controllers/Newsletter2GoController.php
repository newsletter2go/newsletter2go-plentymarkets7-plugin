<?php

namespace Newsletter2Go\Controllers;

use Plenty\Modules\Account\Contact\Contracts\ContactClassRepositoryContract;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Modules\Account\Contact\Contracts\ContactRepositoryContract;
use Plenty\Plugin\Http\Request;
use Plenty\Repositories\Models\PaginatedResult;

class Newsletter2GoController extends Controller
{
    private $url = 'https://logeecom.plentymarkets-cloud01.com/';
    private $apiKey = '';

    public function test(Twig $twig)
    {
        /** @var ContactRepositoryContract $contactRepository */
        $contactRepository = pluginApp(ContactRepositoryContract::class);
        $contacts = $contactRepository->getContactList();

        return $contacts;
    }

    /**
     * Returns all customers on the system
     *
     * @param Request $request
     * @return \Plenty\Repositories\Models\PaginatedResult
     */
    public function customers(Request $request)
    {
        $newsletterSubscribersOnly = filter_var($request->get('newsletterSubscribersOnly', false),
            FILTER_VALIDATE_BOOLEAN);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 50);
        $fields = $request->get('fields', 'id,firstName,lastName,newsletterAllowanceAt,classId');
        $fields = explode(",", $fields);
        $group = $request->get('group', null);
        /** @var ContactRepositoryContract $contactRepository */
        $contactRepository = pluginApp(ContactRepositoryContract::class);
        $contacts = $contactRepository->getContactList([], [], $fields, $page, $limit)->getResult();
        $filteredContacts = [];
        $groupNumber = 0;

        if ($group != null) {
            /** @var ContactClassRepositoryContract $contactClassRepository */
            $contactClassRepository = pluginApp(ContactClassRepositoryContract::class);
            $classes = $contactClassRepository->allContactClasses();

            foreach ($classes as $key => $value) {
                if ($value == $group) {
                    $groupNumber = $key;
                }
            }
        }

        foreach ($contacts as $contact) {
            if ($this->checkEmail($contact['email'])) {
                if ($newsletterSubscribersOnly && $contact['newsletterAllowanceAt'] != null) {
                    if ($group != null && $contact['classId'] == $groupNumber) {
                        array_push($filteredContacts, $contact);
                    }
                    if ($group == null) {
                        array_push($filteredContacts, $contact);
                    }
                }

                if (!$newsletterSubscribersOnly) {
                    if ($group != null && $contact['classId'] == $groupNumber) {
                        array_push($filteredContacts, $contact);
                    }
                    if ($group == null) {
                        array_push($filteredContacts, $contact);
                    }
                }
            }
        }

        return $filteredContacts;
    }

    public function checkEmail($email)
    {
        $notAllowed = ['amazon.com'];

        // Make sure the address is valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $explodedEmail = explode('@', $email);
            $domain = array_pop($explodedEmail);

            if (in_array($domain, $notAllowed)) {
                return false;
            }

            return true;
        }

        return false;
    }
}
