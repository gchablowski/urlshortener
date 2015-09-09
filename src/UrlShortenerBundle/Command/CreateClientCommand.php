<?php

namespace UrlShortenerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('shortener:oauth-server:client:create')
                ->setDescription('Creates a new client')
               ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        //$client->setRedirectUris(" ");
        $client->setAllowedGrantTypes(array('client_credentials'));
        $clientManager->updateClient($client);
        $output->writeln(
                sprintf(
                        'Added a new client with public id <info>%s</info>, secret <info>%s</info>', $client->getPublicId(), $client->getSecret()
                )
        );
    }

}
