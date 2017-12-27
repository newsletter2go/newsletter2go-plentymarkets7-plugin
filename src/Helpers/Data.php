<?php

namespace Newsletter2Go\Helpers;

class Data
{
    const NOT_ALLOWED_DOMAINS = ['amazon.com'];

    /**
     * Validates email domain
     *
     * @param string $email
     *
     * @return bool
     */
    public function checkEmailDomain(string $email): bool
    {
        // Make sure the address is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $explodedEmail = explode('@', $email);
        $domain = array_pop($explodedEmail);

        return !in_array($domain, static::NOT_ALLOWED_DOMAINS);
    }

    /**
     * @param array $contact
     * @param int $hours
     *
     * @return bool
     */
    public function checkHours(array $contact, int $hours): bool
    {
        $timestamp = date('m-d g:Ga', strtotime('-' . $hours . ' hours', strtotime(date('Y-m-d H:i:s'))));

        return strtotime($contact['updatedAt']) >= strtotime($timestamp);
    }
}
