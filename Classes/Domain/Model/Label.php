<?php
namespace Tev\TevLabel\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Label entity.
 */
class Label extends AbstractEntity
{
    /**
     * Key.
     *
     * @var string
     * @validate NotEmpty
     */
    protected $labelKey;

    /**
     * Value.
     *
     * @var string
     */
    protected $labelValue;

    /**
     * Get the label key.
     *
     * @return string
     */
    public function getLabelKey()
    {
        return $this->labelKey;
    }

    /**
     * Set the label key.
     *
     * @param  string $labelKey
     * @return void
     */
    public function setLabelKey($labelKey)
    {
        $this->labelKey = $labelKey;
    }

    /**
     * Get the label value.
     *
     * @return string
     */
    public function getLabelValue()
    {
        return $this->labelValue;
    }

    /**
     * Set the label value.
     *
     * @param  string $labelValue
     * @return void
     */
    public function setLabelValue($labelValue)
    {
        $this->labelValue = $labelValue;
    }
}
