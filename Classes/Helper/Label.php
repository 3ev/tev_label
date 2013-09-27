<?php
namespace Tev\TevLabel\Helper;

/**
 * Helper to render database labels.
 *
 * Usage:
 *
 * ```
 * /**
     * @var \Tev\TevLabel\Helper\Label
     * @inject
    *\/
 * protected $label;
 *
 * $this->label->get($key, $markers);
 * ```
 *
 * @author Muthuswamy Kumaresan <muthu@3ev.com>, 3ev
 * @package Tev\TevLabel
 * @subpackage Helper
 */
class Label
{
    /**
     * @var array $labelCache Request cache for labels
     */
    protected static $labelCache = array();

    /**
     * Search the database or local cache for the supplied label key, optionally
     * replacing the result with the markers array.
     *
     * @return string Found label, or the key if key could not be found
     */
    public function get($key, $markers = array())
    {
        $storageUid = $GLOBALS['TSFE']->rootLine[0]['storage_pid'];

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
?>