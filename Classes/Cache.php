<?php
namespace Tev\TevLabel;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;

/**
 * Cache clearing utility.
 */
class Cache
{
    /**
     * Clear label cache.
     *
     * @param  array                                    $params Parameters array
     * @param  \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     * @return void
     */
    public function clear(&$params, &$pObj)
    {
        if (($params['cacheCmd'] === 'pages') || ($params['cacheCmd'] === 'all')) {
            try {
                $cache = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('tev_label_label_cache');

                $cache->flush();
            } catch(NoSuchCacheException $e) {
                $cache = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheFactory')->create(
                    'tev_label_label_cache',
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['frontend'],
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['backend'],
                    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['options']
                );

                $cache->flush();
            }
        }
    }
}
