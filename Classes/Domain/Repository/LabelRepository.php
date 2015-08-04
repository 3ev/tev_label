<?php
namespace Tev\TevLabel\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for label entities.
 */
class LabelRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function initializeObject()
    {
        // Remove the PID dependency for objects pulled from this repository
        $querySettings = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Return an array of label values indexed by key.
     *
     * @return array
     */
    public function findAllKeysAndValues()
    {
        $all = $this->createQuery()->execute(true);
        $frm = [];

        foreach ($all as $l) {
            $frm[$l['label_key']] = $l['label_value'];
        }

        return $frm;
    }
}
