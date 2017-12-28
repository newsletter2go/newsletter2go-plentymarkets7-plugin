<?php

namespace Newsletter2Go\Helpers;

use Plenty\Modules\Account\Contact\Contracts\ContactRepositoryContract;
use Plenty\Modules\Account\Newsletter\Contracts\NewsletterRepositoryContract;

class Data
{
    /**
     * List of not allowed email domains
     */
    const NOT_ALLOWED_DOMAINS = ['amazon.com'];
    /**
     * @var ContactRepositoryContract
     */
    private $repositoryContract;
    /**
     * @var NewsletterRepositoryContract
     */
    private $newsletterRepository;

    /**
     * Data constructor.
     *
     * @param ContactRepositoryContract $repositoryContract
     * @param NewsletterRepositoryContract $newsletterRepository
     */
    public function __construct(
        ContactRepositoryContract $repositoryContract,
        NewsletterRepositoryContract $newsletterRepository
    ) {
        $this->repositoryContract = $repositoryContract;
        $this->newsletterRepository = $newsletterRepository;
    }

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
        $timestamp = date('m-d g:Ga', strtotime('-' . $hours . ' hours'));

        return strtotime($contact['updatedAt']) >= strtotime($timestamp);
    }

    /**
     * Returns contact list based on parameters
     *
     * @param int $groupId
     * @param bool $subscribed
     * @param int $hours
     * @param array $emails
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getContacts(int $groupId, bool $subscribed, int $hours, array $emails, int $page, int $limit): array
    {
        $paginatedResult = $this->repositoryContract->getContactList([], [], ['*'], $page, $limit);
        $hasNextPage = !$paginatedResult->isLastPage();
        $contacts = $paginatedResult->getResult();
        $filteredContacts = [];

        foreach ($contacts as $contact) {
            if (!$this->checkEmailDomain($contact['email'])) {
                continue;
            }

            if ($hours && !$this->checkHours($contact, $hours)) {
                continue;
            }

            if (!empty($emails) && !in_array($contact['email'], $emails)) {
                continue;
            }

            if ($contact['classId'] !== $groupId) {
                continue;
            }

            if ($subscribed && $contact['newsletterAllowanceAt'] === null) {
                continue;
            }

            $filteredContacts[] = $contact;
        }

        return ['data' => $filteredContacts, 'success' => true, 'hasNextPage' => $hasNextPage];
    }

    /**
     * Returns a list of newsletter recipients
     *
     * @param int $groupId
     * @param bool $subscribed
     * @param int $hours
     * @param array $emails
     *
     * @return array
     */
    public function getRecipients(int $groupId, bool $subscribed, int $hours, array $emails): array
    {
        $result = [];

        $recipients = $this->newsletterRepository->listAllRecipients(['folderId' => $groupId]);
        foreach ($recipients as $recipient) {
            if (!$this->checkEmailDomain($recipient['email'])) {
                continue;
            }

            $recipient['updatedAt'] = $recipients['timestamp'];
            if ($hours && !$this->checkHours($recipient, $hours)) {
                continue;
            }

            if (!empty($emails) && !in_array($recipient['email'], $emails)) {
                continue;
            }

            // if recipient is not confirmed then he is not subscribed
            if ($subscribed && (string)$recipients['confirmedTimestamp'] === '0000-00-00 00:00:00') {
                continue;
            }

            if ($recipient['contactId']) {
                $recipient = $this->repositoryContract->findContactById($recipient['contactId'])->toArray();
            }

            $result[] = $recipient;
        }

        return ['data' => $result, 'success' => true, 'hasNextPage' => false];
    }
}
