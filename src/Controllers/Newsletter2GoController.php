<?php

namespace Newsletter2Go\Controllers;

use Plenty\Modules\Account\Contact\Contracts\ContactClassRepositoryContract;
use Plenty\Plugin\Controller;
use Plenty\Modules\Account\Contact\Contracts\ContactRepositoryContract;
use Plenty\Plugin\Http\Request;
use Plenty\Repositories\Models\PaginatedResult;

class Newsletter2GoController extends Controller
{
    private $version = 1.0;

    /**
     * @return bool
     */
    public function test()
    {
        $response['test'] = true;
        $response['success'] = true;
        return $response;
    }

    /**
     * @param Request $request
     * @return float
     */
    public function version(Request $request)
    {
        $response['data'] = $this->version;
        $response['success'] = true;
        return $response;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function customerCount(Request $request)
    {
        /** @var ContactRepositoryContract $contactRepository */
        $contactRepository = pluginApp(ContactRepositoryContract::class);
        $contacts = $this->customers($request);

        return count($contacts);
    }

    /**
     * Returns all customers on the system
     *
     * @param Request $request
     * @return array
     */
    public function customers(Request $request)
    {
        $newsletterSubscribersOnly = filter_var($request->get('newsletterSubscribersOnly', false),
            FILTER_VALIDATE_BOOLEAN);
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 50);
        $hours = $request->get('hours', null);
        $emails = $request->get('emails', []);
        $fields = $request->get('fields', ['id','firstName','lastName','newsletterAllowanceAt','classId','updatedAt','gender', 'birthdayAt']);
        $groups = $request->get('groups', []);
        /** @var ContactRepositoryContract $contactRepository */
        $contactRepository = pluginApp(ContactRepositoryContract::class);
        $contacts = $contactRepository->getContactList([], [], $fields, $page, $limit)->getResult();
        $filteredContacts = [];

        foreach ($contacts as $contact) {
            if ($this->checkEmail($contact['email'])) {
                if ($newsletterSubscribersOnly && $contact['newsletterAllowanceAt'] === null) {
                    continue;
                } else {
                    if (!empty($groups) && in_array($contact['classId'], $groups)) {
                        array_push($filteredContacts, $contact);
                    } elseif (empty($groups)) {
                        array_push($filteredContacts, $contact);
                    }
                }
            }
        }

        if ($hours != null) {
            $filteredContacts = $this->checkHours($filteredContacts, $hours);
        }

        if (!empty($emails)) {
            $filteredContacts = $this->filterEmails($filteredContacts, $emails);
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

    public function checkHours($contacts, $hours)
    {
        $hoursContacts = [];
        $timestamp = date('m-d g:Ga', strtotime('-' . $hours . ' hours', strtotime(date('Y-m-d H:i:s'))));
        foreach ($contacts as $contact) {
            if (strtotime($contact['updatedAt']) > strtotime($timestamp)) {
                array_push($hoursContacts, $contact);
            }
        }

        return $hoursContacts;
    }

    public function filterEmails($contacts, $emails)
    {
        $emailContacts = [];
        foreach ($contacts as $contact) {
            if (in_array($contact['email'], $emails)) {
                array_push($emailContacts, $contact);
            }
        }

        return $emailContacts;
    }
}
