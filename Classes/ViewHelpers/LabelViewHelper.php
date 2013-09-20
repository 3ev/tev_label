<?php

namespace Tev\TevLabel\ViewHelpers;

/**
 * View helper to render database labels.
 *
 * Usage:
 *
 * ```
 * {namespace tvl=Tev\TevLabel\ViewHelpers}
 *
 * <tvl:label key="my.label" markers="{':markerA': 'hello', ':markerB': 'hello'}" />
 * ```
 *
 * @author Ben Constable <benconstable@3ev.com>, 3ev
 * @package Tev\TevLabel
 * @subpackage ViewHelpers
 */
class LabelViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var array $labelCache Request cache for labels
     */
    protected static $labelCache = array();

    /**
     * @see parent::initializeArguments()
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('key', 'string', 'Label Key', true);
        $this->registerArgument('markers', 'array', 'Replace markers');
    }

    /**
     * Search the database or local cache for the supplied label key, optionally
     * replacing the result with the markers array.
     *
     * @return string Found label, or the key if key could not be found
     */
    public function render()
    {
        $storageUid = $GLOBALS['TSFE']->rootLine[0]['storage_pid'];
        $key        = trim($this->arguments['key']);
        $markers    = $this->arguments['markers'];

        // Replace markers in the label with dynamic values
        $replaceValues = function ($label) use ($markers) {
            foreach ($markers as $key => $value) {
                $label = str_replace($key, $value, $label);
            }
            return $label;
        };

        if (!is_array(self::$labelCache[$storageUid])) {
            self::$labelCache[$storageUid] = array();
            $db = $GLOBALS['TYPO3_DB'];

            $labels = $db->exec_SELECTgetRows(
                'label_key, label_value',
                'tx_tevlabel_labels',
                'hidden = 0 AND deleted = 0 AND pid  = ' . $db->quoteStr($storageUid)
            );

            foreach ($labels as $label) {
                self::$labelCache[$label['label_key']] = $label['label_value'];
            }
        }

        if (isset(self::$labelCache[$key])) {
            return $replaceValues(self::$labelCache[$key]);
        } else {
            return $key;
        }
    }
}
