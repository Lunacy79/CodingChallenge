<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use App\Controller\ExportController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @author Carolin Ivens
 */

class ExportCommand extends Command
{
    private $exportController;

    public function __construct(ExportController $exportController)
    {
        $this->exportController = $exportController;

        parent::__construct();
    }

    protected function configure()
    {
      $this
        ->setName('app:export')
        ->setDescription('Exports Userdata to different formats')
        ->addArgument('formats', InputArgument::OPTIONAL, 'The export format.')  
      ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $encoders = array(new XmlEncoder(), new CsvEncoder());
      $normalizers = array(new ObjectNormalizer());
      $serializer = new Serializer($normalizers, $encoders);
      
      $userData = $this->exportController->getUserData();
      
      if($input->getArgument('formats')==='xml'){
          $output->write($xmlContent = $serializer->serialize($userData, 'xml'));
      }  
      elseif($input->getArgument('formats')==='csv'){
          $output->write($xmlContent = $serializer->serialize($userData, 'csv'));
      }
      else{
        $output->write('No user found');
      }
            
    }
}
