<?php

namespace Elemecca\MailchimpBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ListShowCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mailchimp:list:show')
            ->setDescription('Display the lists in the Mailchimp account.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getContainer()->get('elemecca_mailchimp.client');
        $lists = $client->getLists();

        $table = new Table($output);
        $table->setStyle('compact');

        $table->setHeaders(['ID', 'Name']);
        foreach ($lists as $list) {
            $table->addRow([
                $list->getId(),
                $list->getName(),
            ]);
        }

        $table->render();
    }
}