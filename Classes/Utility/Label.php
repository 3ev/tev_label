<?php
namespace Tev\TevLabel\Utility;

/**
 * Utility to render database labels.
 *
 * Usage:
 *
 * ```
 * /**
     * @var \Tev\TevLabel\Utility\Label
     * @inject
    *\/
 * protected $label;
 *
 * $this->label->get($key, $markers);
 * ```
 *
 * @author Muthuswamy Kumaresan <muthu@3ev.com>, 3ev
 * @package Tev\TevLabel
 * @subpackage Utility
 */
class Label
{
    /**
     * Request cache for labels.
     *
     * @var array $labelCache
     */
    protected static $labelCache = array();

    /**
     * Label persistent cache.
     *
     * @var \TYPO3\CMS\Core\Cache\Cache
     */
    private static $cache = null;

    /**
     * Search the database or local cache for the supplied label key, optionally
     * replacing the result with the markers array.
     *
     * @param string $key              Label key
     * @param array  $markers          Optional array of markes to replace in the translation.
     *                                 Key/value pairs
     * @param int    $storageFolderUid Storage folder override
     * @return string Found label, or the key if key could not be found
     */
    public function get($key, $markers = array(), $storageUid = null)
    {
        if ($storageUid === null) {
            $storageUid = $GLOBALS['TSFE']->rootLine[0]['storage_pid'];
            if (!$storageUid) {
                return $key;
            }
        }

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

            if (($labels = $this->getCache()->get('labels_' . $storageUid)) === false) {
                error_log('Not in cache');

                $labels = $db->exec_SELECTgetRows(
                    'label_key, label_value',
                    'tx_tevlabel_labels',
                    'hidden = 0 AND deleted = 0 AND pid  = ' . $db->quoteStr($storageUid)
                );
                $this->getCache()->set('labels_' . $storageUid, $labels);
            }

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

    /**
     * Get the cache to retrieve labels.
     *
     * @return \TYPO3\CMS\Core\Cache\Cache
     */
    private function getCache()
    {
        if (self::$cache === null) {
            \TYPO3\CMS\Core\Cache\Cache::initializeCachingFramework();

            try {
                self::$cache = $GLOBALS['typo3CacheManager']->getCache('tev_label_label_cache');
            } catch(\TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException $e) {
                self::$cache = $GLOBALS['typo3CacheFactory']->create(
                    'tev_label_label_cache',
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['frontend'],
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['backend'],
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['options']
                );
            }
        }

        return self::$cache;
    }
}
