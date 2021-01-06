<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\Send;
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Utils\HttpStatusCodeUtils;
use App\Services\ContactService;

class ContactController extends Controller
{
    /**
     * @var ContactService
     */
    public $service;

    /**
     * Create a new controller instance.
     * @param ContactService $service
     * @return void
     */
    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    /**
     * Send an contact email
     *
     * @return Json
     */
    public function send(Send $request)
    {
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        $this->service->send($name, $email, $message);

        return (new DefaultResource(['Email was sent successfully.']))
            ->response()
            ->setStatusCode(HttpStatusCodeUtils::OK);
    }
}
