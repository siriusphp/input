<?php
namespace Sirius\Forms\Widget\Traits;

use Sirius\Forms\Html\ExtendedTag;

trait HasInputTrait
{

    /**
     * @var ExtendedTag
     */
    protected $input;

    /**
     * Set the input HTML element for this element
     *
     * @param ExtendedTag $input
     * @return $this
     */
    function setInput(ExtendedTag $input)
    {
        $this->input = $input;
        return $this;
    }

    /**
     * Get the input HTML element for this element
     *
     * @return mixed
     */
    function getInput()
    {
        return $this->input;
    }
}
