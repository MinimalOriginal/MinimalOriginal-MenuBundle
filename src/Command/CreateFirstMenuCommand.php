<?php

namespace MinimalOriginal\MenuBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MinimalOriginal\MenuBundle\Entity\Menu;

class CreateFirstMenuCommand extends ContainerAwareCommand
{
    protected function configure()
    {
      $this
          ->setName('minimal_menu:create-first-menu')
          ->setDescription('Creates the first menu of the site.')
          ->setHelp('This command allows you to create a first menu for the website.')
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'First menu creator',
            '============',
            '',
        ]);
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        
        $menu_pricipal = new Menu();
        $menu_pricipal->setTitle("Menu principal");
        $em->persist($menu_pricipal);

        $menu_footer = new Menu();
        $menu_footer->setTitle("Footer");
        $em->persist($menu_footer);

        $em->flush();

        $output->writeln('The first menu has been successfully generated!');


    }
}
