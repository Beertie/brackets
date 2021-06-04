<?php
declare(strict_types=1);

namespace Brackets\Commands;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class WinnerCommand  extends Command
{
    protected static string $defaultName = 'app:create-user';

    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        return Command::SUCCESS;

    }

    /**
     * @test
     */
    public function bar(): void
    {
        $data = [];
        $files = scandir(__DIR__ . '/../data');
        $x = 0;
        foreach ($files as $file) {
            $x++;
            if ($x < 3) {
                continue;
            }
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open(__DIR__ . '/../data/' . $file);
            $countSheets = 0;
            foreach ($reader->getSheetIterator() as $sheet) {
                $count = 1;
                $finalFour = '';
                $finals = '';
                $winner = '';
                foreach ($sheet->getRowIterator() as $row) {
                    if ($count === 9) {
                        $finalFour .= $row->getCellAtIndex(7)->getValue() . " ";
                        $finalFour .= $row->getCellAtIndex(15)->getValue() . " ";
                    }
                    if ($count === 24) {
                        $finalFour .= $row->getCellAtIndex(7)->getValue() . " ";
                        $finalFour .= $row->getCellAtIndex(15)->getValue();
                    }
                    if ($count === 14) {
                        $finals .= $row->getCellAtIndex(11)->getValue() . " ";
                    }
                    if ($count === 19) {
                        $finals .= $row->getCellAtIndex(11)->getValue() . " ";
                    }
                    if ($count === 31) {
                        $winner = $row->getCellAtIndex(11)->getValue();
                    }
                    if ($finals === ' 4') {
                        $this->assertTrue(true);
                    }
                    $count++;
                }
                if ($winner === '') {
                    $this->assertTrue(true);
                    break;
                }
                if ($finals === ' 4 ') {
                    $this->assertTrue(true);
                    break;
                }
                if (!isset($data['finalFour'][$finalFour])) {
                    $data['finalFour'][$finalFour] = 0;
                }
                if (!isset($data['finals'][$finals])) {
                    $data['finals'][$finals] = 0;
                }
                if (!isset($data['winner'][$winner])) {
                    $data['winner'][$winner] = 0;
                }
                $data['finalFour'][$finalFour]++;
                $data['finals'][$finals]++;
                $data['winner'][$winner]++;
            }
            $reader->close();
        }
        $this->assertTrue(true);
    }
}