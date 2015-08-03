<?php
namespace Tev\TevLabel\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to render database labels.
 *
 * Usage:
 *
 * ```
 * {namespace tvl=Tev\TevLabel\ViewHelpers}
 *
 * <tvl:label key="my.label" markers="{_markerA: 'hello', _markerB: 'hello'}" />
 * ```
 */
class LabelViewHelper extends AbstractViewHelper
{
    /**
     * Request cache for labels
     *
     * @var array
     */
    protected static $labelCache = array();

    /**
     * @var \Tev\TevLabel\Utility\Label
     * @inject
    */
    protected $label;

    /**
     * {@inheritdoc}
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
