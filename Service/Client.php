<?php

namespace Elemecca\MailchimpBundle\Service;

use Elemecca\MailchimpBundle\Model\MailchimpList;

class Client
{
    private $client;

    public function __construct($apiKey) {
        $region = "us1";
        $matches = [];
        if (preg_match('/-([a-z]+[0-9]+)$/', $apiKey, $matches)) {
            $region = $matches[1];
        }

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => "https://$region.api.mailchimp.com/3.0/",
            'auth' => ['api', $apiKey, 'basic'],
        ]);
    }


    /**
     * @return MailchimpList[]
     */
    public function getLists() {
        $res = $this->client->get('lists');
        $body = json_decode($res->getBody(), JSON_OBJECT_AS_ARRAY);

        $lists = [];
        foreach ($body['lists'] as $record) {
            $lists[] = MailchimpList::fromRecord($record);
        }
        return $lists;
    }
}
