<?php

namespace Newsletter2Go\Helpers;

class Data
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function checkEmail(string $email): bool
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

    /**
     * @param array $contacts
     * @param int $hours
     *
     * @return array
     */
    public function checkHours(array $contacts, int $hours): array
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

    /**
     * @param array $contacts
     * @param array $emails
     *
     * @return array
     */
    public function filterEmails(array $contacts, array $emails): array
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
