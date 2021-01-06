<?php

namespace App\Services;

use App\Interfaces\Services\EmailInterface;
use Illuminate\Support\Facades\Mail;

class EmailService implements EmailInterface
{
    /**
     * @var Mail
     */
    public $mail;

    /**
     * @var String
     */
    public $template;

    /**
     * @var Array
     */
    public $parameters;

    /**
     * @var String
     */
    public $mailFromAddress;

    /**
     * @var String
     */
    public $mailToAddressAddress;

    /**
     * @var String
     */
    public $mailToName;

    /**
     * @var String
     */
    public $mailSubject;

    /**
     * Constructor method to instantiate a instance
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Initialize the email settings
     * @param String $template
     * @param Array $parameters
     * @param String $mailToAddress
     * @param String $mailToName
     * @param String $mailFromAddress
     * @param String $subject
     * @return void
     */
    private function initialize(String $template, array $parameters, String $mailToAddress, String $mailToName, String $mailFromAddress, String $subject)
    {
        $this->setTemplate($template);
        $this->setTemplateParameters($parameters);
        $this->setMailTo($mailToAddress);
        $this->setMailToName($mailToName);
        $this->setMailFromAddress($mailFromAddress);
        $this->setSubject($subject);
    }

    /**
     * Send the email message
     * @param String $template
     * @param Array $parameters
     * @param String $mailToAddress
     * @param String $mailToName
     * @param String $mailFromAddress
     * @param String $subject
     * @return void
     */
    public function sendEmail(String $template, array $parameters, String $mailToAddress, String $mailToName, String $mailFromAddress, String $subject)
    {
        $this->initialize($template, $parameters, $mailToAddress, $mailToName, $mailFromAddress, $subject);
        $this->send();
    }

    /**
     * Gets the mail template
     * @param String $template
     * @return String $this->template
     */
    private function getTemplate()
    {
        return $this->template;
    }

    /**
     * Gets the mail template parameters
     * @param Array $parameters
     * @return Array $this->parameters
     */
    private function getTemplateParameters()
    {
        return $this->parameters;
    }

    /**
     * Gets the mail to
     * @param String $mailToAddress
     * @return String $this->mailToAddress
     */
    private function getMailToAddress()
    {
        return $this->mailToAddress;
    }

    /**
     * Gets the mail to name
     * @param String $mailToName
     * @return String $this->mailToName
     */
    private function getMailToName()
    {
        return $this->mailToName;
    }

    /**
     * Gets the mail mail from address
     * @param String $mailFromAddress
     * @return String $this->mailFromAddress
     */
    private function getMailFromAddress()
    {
        return $this->mailFromAddress;
    }

    /**
     * Gets the mail subject
     * @param String $subject
     * @return String $this->subject
     */
    private function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the mail template
     * @param String $template
     * @return String $this->template
     */
    private function setTemplate(String $template)
    {
        return $this->template = $template;
    }

    /**
     * Sets the mail template parameters
     * @param Array $parameters
     * @return Array $this->parameters
     */
    private function setTemplateParameters(array $parameters)
    {
        return $this->parameters = $parameters;
    }

    /**
     * Sets the mail to
     * @param String $mailToAddress
     * @return String $this->mailToAddress
     */
    private function setMailTo(String $mailToAddress)
    {
        return $this->mailToAddress = $mailToAddress;
    }

    /**
     * Sets the mail to name
     * @param String $mailToName
     * @return String $this->mailToName
     */
    private function setMailToName(String $mailToName)
    {
        return $this->mailToName = $mailToName;
    }

    /**
     * Sets the mail mailFromAddress
     * @param String $mailFromAddress
     * @return String $this->mailFromAddress
     */
    private function setMailFromAddress(String $mailFromAddress)
    {
        return $this->mailFromAddress = $mailFromAddress;
    }

    /**
     * Sets the mail subject
     * @param String $subject
     * @return String $this->subject
     */
    private function setSubject(String $subject)
    {
        return $this->subject = $subject;
    }

    /**
     * Send an email message
     * @return Boolean
     */
    public function send()
    {
        $template = $this->getTemplate();
        $parameters = $this->getTemplateParameters();
        $mailFromAddress = $this->getMailFromAddress();
        $mailToAddress = $this->getMailToAddress();
        $mailToName = $this->getMailToName();
        $mailSubject = $this->getSubject();

        try {
            return $this->mail::send(
                $template,
                $parameters,
                function ($message) use ($mailFromAddress, $mailToAddress, $mailToName, $mailSubject) {
                    $message
                        ->from($mailFromAddress)
                        ->to($mailToAddress, $mailToName)
                        ->subject($mailSubject);
                }
            );
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }
}
