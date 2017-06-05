<?php

namespace Elemecca\MailchimpBundle\Service;

class Client
{
    private $client;

    public function __construct($apiKey) {
        $region = "us1";
        $matches = [];
        if (preg_match('-([a-z]+[0-9]+)$', $apiKey, $matches)) {
            $region = $matches[1];
        }

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "https://$region.api.mailchimp.com/3.0/",
            'auth' => ['api', $apiKey, 'basic'],
        ]);
    }
}
