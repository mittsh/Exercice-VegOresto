<?php

namespace App\Command;

use App\Controller\ImportRestaurantsController;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'import';

    protected function configure()
    {
        $this
            ->setDescription('Import restaurants')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Restaurant JSON file path')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // get filepath
        $filepath = $input->getArgument('filepath');
        $filepath = realpath(getcwd() . '/' . $filepath);
        if (false === $filepath) {
            $io->error(sprintf('Can\'t find file at: %s', $input->getArgument('filepath')));
            return;
        }
        $io->note(sprintf('Importing restaurants from: %s', $filepath));

        $json = json_decode(file_get_contents($filepath), true);

        $importController = new ImportRestaurantsController();
        $importController->setContainer($this->getContainer());
        $count = $importController->importRestaurants($json);

        $io->success(sprintf('Imported %d restaurants', $count));
    }
}
