<?php

namespace Elemecca\MailchimpBundle\Exception;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class MailchimpApiException extends \RuntimeException
{
    protected $type;
    protected $title;
    protected $detail;

    public static function create(RequestException $cause) {
        $self = new self($cause);

        if ($cause instanceof ConnectException) {
            $ctx = $cause->getHandlerContext();
            $self->message = "API connection failed: "
                . (isset($ctx['error']) ? $ctx['error'] : $cause->getMessage())
            ;
            return $self;
        }

        $body = null;
        $res = $cause->getResponse();
        if ($res) {
            $body = json_decode($res->getBody(), true);
        }

        if ($body) {
            $self->type = $body['type'];
            $self->title = $body['title'];
            $self->detail = $body['detail'];
            $self->message = "{$self->title}: {$self->detail}";
        } else {
            $self->message = "API request failed: {$cause->getMessage()}";
        }

        return $self;
    }


    /** @return string | null */
    public function getTypeUri() {
        return $this->type;
    }

    /** @return string | null */
    public function getTitle() {
        return $this->title;
    }

    /** @return string | null */
    public function getDetailMessage() {
        return $this->detail;
    }
}