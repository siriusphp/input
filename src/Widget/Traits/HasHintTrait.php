<?php
namespace Sirius\Forms\Widget\Traits;

use Sirius\Forms\Html\ExtendedTag;

trait HasHintTrait
{

    /**
     * @var ExtendedTag
     */
    protected $hint;

    /**
     * Set the hint HTML element for this input/fieldset/etc
     *
     * @param ExtendedTag $hint
     * @return $this
     */
    function setHint(ExtendedTag $hint)
    {
        $this->hint = $hint;
        return $this;
    }

    /**
     * Get the hint HTML element for this input/fieldset/etc
     *
     * @return mixed
     */
    function getHint()
    {
        return $this->hint;
    }
}
