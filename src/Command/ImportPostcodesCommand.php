<?php

namespace App\Command;

use App\Entity\Postcode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:postcodes',
    description: 'Import Postcodes to DB',
)]
class ImportPostcodesCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly string $projectDir
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $folder =  $this->projectDir . '/public/csv';
        if (!is_dir($folder)) {
            $output->writeln('Invalid folder path.');
            return Command::FAILURE;
        }

        $csvFiles = glob($folder . '/*.csv');

        foreach ($csvFiles as $csvFile) {
            $this->importCsvFile($csvFile, $io);
        }

        return Command::SUCCESS;
    }

    /**
     * Function that uses bulk insert in order to do batch technique
     */
    private function importCsvFile(string $csvFile, SymfonyStyle $io): void
    {
        $csvData = array_map('str_getcsv', file($csvFile));

        for ($i = 1; $i <= count($csvData); ++$i) {

            $existingPostcode = $this->em->getRepository(Postcode::class)->findOneBy(['name' => $csvData[$i][0]]);
            if ($existingPostcode) {
                continue; // Skip already imported postcode
            }

            $postcode = new Postcode();
            $postcode->setName($csvData[$i][0]); 
            $postcode->setLatitude($csvData[$i][42]);
            $postcode->setLongitude($csvData[$i][43]);
            $this->em->persist($postcode);

            if (($i % 50) === 0) {
                $this->em->flush();
                $this->em->clear();
                $io->success('50 new Postcodes added');
            }
        }
        // Flush remaining records
        $this->em->flush();
        $this->em->clear();
    }
}
