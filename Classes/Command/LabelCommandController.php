<?php
namespace Tev\TevLabel\Command;

use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use Tev\TevLabel\Domain\Model\Label;

/**
 * Label import script.
 */
class LabelCommandController extends CommandController
{
    /**
     * Label repo.
     *
     * @var \Tev\TevLabel\Domain\Repository\LabelRepository
     * @inject
     */
    private $labelRepo;

    /**
     * Import labels from a .ini file to the database.
     *
     * @param  string $path    Label file path
     * @param  int    $storage Storage folder ID to import to
     * @return void
     */
    public function importCommand($path, $storage)
    {
        $this->outputLine('Importing labels');

        if (!file_exists($path)) {
            $this->outputLine('Could not find label file');
            $this->quit(1);
        }

        $labels = parse_ini_file($path);

        if (count($labels)) {
            $this->outputLine('Found ' . count($labels) . ' labels');

            $inserted = 0;
            $skipped = 0;

            foreach ($labels as $key => $value) {
                $existing = $this->labelRepo->findOneByLabelKey($key);

                if (!$existing) {
                    $label = new Label;
                    $label->setPid($storage);
                    $label->setLabelKey($key);
                    $label->setLabelValue($value);

                    $this->labelRepo->add($label);

                    $inserted++;
                } else {
                    $skipped++;
                }
            }

            $this->outputLine('Inserted ' . $inserted . ' new label(s).');
            $this->outputLine('Skipped ' . $skipped . ' existing label(s).');
            $this->quit();
        } else {
            $this->outputLine('No labels found to import');
            $this->quit();
        }
    }
}
