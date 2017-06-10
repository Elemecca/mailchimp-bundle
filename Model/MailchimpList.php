<?php

namespace Elemecca\MailchimpBundle\Model;

class MailchimpList
{
    private $id;
    private $name;

    public static function fromRecord($record) {
        $self = new self();
        $self->id = $record['id'];
        $self->name = $record['name'];
        return $self;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
}