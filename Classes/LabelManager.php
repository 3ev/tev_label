<?php
namespace Tev\TevLabel;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Utility to render database labels.
 *
 * Usage:
 *
 * ```
 * /**
 *  * @var \Tev\TevLabel\LabelManager
 *  * @inject
 *  *\/
 * protected $label;
 *
 * $this->label->get($key, $markers);
 * ```
 */
class LabelManager implements SingletonInterface
{
    /**
     * Cache manager.
     *
     * @var \TYPO3\CMS\Core\Cache\CacheManager
     * @inject
     */
    private $cacheManager;

    /**
     * Cache factory/
     *
     * @var \TYPO3\CMS\Core\Cache\CacheFactory
     */
    private $cacheFactory;

    /**
     * Label repository.
     *
     * @var \Tev\TevLabel\Domain\Repository\LabelRepository
     * @inject
     */
    private $labelRepo;

    /**
     * Request cache for labels.
     *
     * @var array
     */
    private $labelCache;

    /**
     * Label persistent cache.
     *
     * @var \TYPO3\CMS\Core\Cache\Cache
     */
    private $cache;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->labelCache = null;
        $this->cache = null;
        $this->cacheFactory = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheFactory');
        $this->cacheManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager');
    }

    /**
     * Search the database or local cache for the supplied label key, optionally
     * replacing the result with the markers array.
     *
     * @param  string $key     Label key
     * @param  array  $markers Optional array of markes to replace in the translation.
     *                         Key/value pairs
     * @return string          Found label, or the key if key could not be found
     */
    public function get($key, $markers = [], $returnKeyOnEmpty = 'true')
    {
        if ($this->labelCache === null) {
            if (($this->labelCache = $this->getCache()->get('tev_labels')) === false) {
                $this->labelCache = $this->labelRepo->findAllKeysAndValues();
                $this->getCache()->set('tev_labels', $this->labelCache);
            }
        }

        if (isset($this->labelCache[$key])) {
            return $this->replaceValues($this->labelCache[$key], $markers);
        } else {
            $ini = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']).'/config/phing.properties');
            $env = $ini['build.environment'];

            if($returnKeyOnEmpty || $env == 'Development') {
                return $key;
            }
        }
    }

    /**
     * Get the cache to retrieve labels.
     *
     * @return \TYPO3\CMS\Core\Cache\Cache
     */
    private function getCache()
    {
        if ($this->cache === null) {
            try {
                $this->cache = $this->cacheManager->getCache('tev_label_label_cache');
            } catch(NoSuchCacheException $e) {
                $this->cache = $this->cacheFactory->create(
                    'tev_label_label_cache',
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['frontend'],
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['backend'],
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['options']
                );
            }
        }

        return $this->cache;
    }

    /**
     * Replace values in the given label.
     *
     * @param  string $label   Original label
     * @param  array  $markers Replacements hash
     * @return string          Modified label
     */
    private function replaceValues($label, $markers)
    {
        if (is_array($markers)) {
            foreach ($markers as $key => $value) {
                $label = str_replace($key, $value, $label);
            }
        }

        return $label;
    }
}
