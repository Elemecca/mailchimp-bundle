<?php

namespace Elemecca\MailchimpBundle\Service;

use Elemecca\MailchimpBundle\Exception\MailchimpApiException;
use Elemecca\MailchimpBundle\Model\MailchimpList;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;

class Client
{
    private $client;

    public function __construct($apiKey) {
        $region = "us1";
        $matches = [];
        if (preg_match('/-([a-z]+[0-9]+)$/', $apiKey, $matches)) {
            $region = $matches[1];
        }

        $stack = HandlerStack::create();

        // use our more detailed exception for HTTP errors
        // our middleware needs to run *after* `http_errors` on the response
        // but the methods are named for the request, so we use the opposite
        $stack->before('http_errors', function ($handler) {
            return function ($request, $options) use ($handler) {
                return $handler($request, $options)->then(
                    null,
                    function ($reason) {
                        if ($reason instanceof RequestException) {
                            throw MailchimpApiException::create($reason);
                        }
                    }
                );
            };
        }, 'mailchimp_errors');

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "https://$region.api.mailchimp.com/3.0/",
            'auth' => ['api', $apiKey, 'basic'],
            'handler' => $stack,
        ]);
    }


    public function getLists() {
        $res = $this->client->get('lists');
        $body = json_decode($res->getBody());
        return $body->lists;
    }
}
