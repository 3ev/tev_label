<?php

namespace Tev\TevLabel\Command;

/**
 * Label import script.
 *
 * @author Ben Constable <benconstable@3ev.com>, 3ev
 * @package Tev\TevLabel
 * @subpackage Command
 */
class LabelCommandController extends \Tx_Tev_Command_BaseCommandController
{
    // Path to the directory where the labels are stored
    const DATA_PATH = '/data/translate';

    /**
     * Import labels to the database.
     *
     * @param string $site Name of folder containing labels in data/translate
     * @param string $locale Local of labels to import e.g en/de. Maps to ini file name (en.ini/de.ini)
     * @param int $storage Storage folder ID to import to
     */
    public function importCommand($site, $locale, $storage)
    {
        $this->startMessage("Import labels for '$site' in locale '$locale'");

        $path = $this->getPath($site, $locale);

        if (!file_exists($path)) {
            $this->out('Could not find label file', 2);
        } elseif ($storage === null) {
            $this->out('Not import Storage ID given');
        } else {
            $labels = parse_ini_file($path);

            if (count($labels)) {
                $this->out('Found ' . count($labels) . ' labels', 2);
                $this->out();

                $inserted = 0;
                $skipped = 0;
                $db = $GLOBALS['TYPO3_DB'];

                foreach ($labels as $key => $value) {
                    $result = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                        'uid',
                        'tx_tevlabel_labels',
                        'hidden = 0 AND deleted = 0 AND label_key = ' . $db->fullQuoteStr($key) . ' AND pid  = ' . $db->quoteStr($storage)
                    );

                    $dbLabel = count($result);

                    // Insert if label is new
                    if (!$dbLabel) {
                        $this->out("Inserting new label '{$key}'", 4);

                        $insertFields = array(
                            'pid' => $storage,
                            'tstamp' => time(),
                            'crdate' => time(),
                            'cruser_id' => 0,
                            'deleted' => 0,
                            'hidden' => 0,
                            'label_key' => $key,
                            'label_value' => $value
                        );

                        $db->exec_INSERTquery(
                            'tx_tevlabel_labels',
                            $insertFields
                        );

                        $inserted++;
                    } else {
                        $this->out("Label '{$key}', already exists, did not insert", 4);
                        $skipped++;
                    }
                }

                // Show import results
                $this->out('');
                $this->out('Inserted ' . $inserted . ' new label(s).', 2);
                $this->out('Skipped ' . $skipped . ' existing label(s).', 2);
            } else {
                $this->out('No labels found, did not import.', 2);
            }
        }

        $this->endMessage();
    }

    /**
     * List labels and keys.
     *
     * @param string $site Name of folder containing labels in data/translate
     * @param string $locale Local of labels to import e.g en/de. Maps to ini file name (en.ini/de.ini)
     */
    public function listCommand($site, $locale)
    {
        $this->startMessage("Listing labels for '$site' in locale '$locale'");

        $path = $this->getPath($site, $locale);

        if (!file_exists($path)) {
            $this->out('Could not find label file', 2);
        } else {
            $labels = parse_ini_file($path);

            foreach ($labels as $key => $value) {
                $this->out('Key: ' . $key, 4);
                $this->out('Value: ' . $value, 6);
            }
        }

        $this->endMessage();
    }

    /**
     * Get the full path to the label file that's being imported.
     *
     * @return string
     */
    private function getPath($site, $locale)
    {
        return
            PATH_site . '..' . self::DATA_PATH . '/' .
            $site . '/' .
            $locale . '.ini';
    }
}
