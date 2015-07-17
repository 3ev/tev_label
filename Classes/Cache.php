<?php

namespace Tev\TevLabel;

class Cache
{
    /**
     * Clear label cache.
     *
     * @param array $params Parameters array
     * @param ??    $pObj
     */
    public function clear(&$params, &$pObj)
    {
        if (($params['cacheCmd'] === 'pages') || ($params['cacheCmd'] === 'all')) {
            \TYPO3\CMS\Core\Cache\Cache::initializeCachingFramework();

            try {
                $cache = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('tev_label_label_cache');

                $cache->flush();
            } catch(\TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException $e) {
                $cache = $GLOBALS['typo3CacheFactory']->create(
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
