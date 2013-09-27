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
     * @var \Tev\TevLabel\Helper\Label
     * @inject
    */
    protected $label;

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
        $key        = trim($this->arguments['key']);
        $markers    = $this->arguments['markers'];

        return $this->label->get($key, $markers);
    }
}
