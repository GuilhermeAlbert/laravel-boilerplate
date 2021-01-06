<?php

namespace App\Services;

use App\Interfaces\Services\ContactInterface;
use App\Utils\{ContactUtils, EnvironmentUtils};

class ContactService implements ContactInterface
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * Constructor method to instantiate a instance
     * @param EmailService $emailService
     * @param EnvironmentUtils $environmentUtils
     * @param ContactUtils $contactUtils
     * @return Instance
     */
    public function __construct(
        EmailService $emailService,
        EnvironmentUtils $environmentUtils,
        ContactUtils $contactUtils
    ) {
        $this->emailService = $emailService;
        $this->environmentUtils = $environmentUtils;
        $this->contactUtils = $contactUtils;
    }

    /**
     * Send an email message
     * @param String $name 
     * @param String $email 
     * @param String $message
     * @return Boolean
     */
    public function send($name, $email, $message)
    {
        $parameters = [
            "name"    => $name,
            "email"   => $email,
            "comment" => $message
        ];

        $template = $this->contactUtils::MAIL_TEMPLATE;
        $mailFromAddress = $this->environmentUtils->getByKey($this->environmentUtils::MAIL_FROM_ADDRESS);
        $mailToAddress = $mailFromAddress;
        $mailToName = $this->environmentUtils->getByKey($this->environmentUtils::MAIL_FROM_NAME);
        $subject = $this->contactUtils::MAIL_SUBJECT;

        return $this->emailService->sendEmail(
            $template,
            $parameters,
            $mailToAddress,
            $mailToName,
            $mailFromAddress,
            $subject
        );
    }
}
