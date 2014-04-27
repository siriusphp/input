<?php
namespace Sirius\Forms\Widget\Traits;

use Sirius\Forms\Html\ExtendedTag;

trait HasLabelTrait
{

    /**
     * @var ExtendedTag
     */
    protected $label;

    /**
     * Set the label HTML element for this input/fieldset/etc
     *
     * @param ExtendedTag $label
     * @return $this
     */
    function setLabel(ExtendedTag $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the label HTML element for this input/fieldset/etc
     *
     * @return ExtendedTag
     */
    function getLabel()
    {
        return $this->label;
    }
}
