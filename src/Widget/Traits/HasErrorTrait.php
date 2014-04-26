<?php
namespace Sirius\Forms\Widget\Traits;

use Sirius\Forms\Html\ExtendedTag;

trait HasErrorTrait
{

    /**
     * @var ExtendedTag
     */
    protected $error;

    /**
     * Set the error HTML element for this input/fieldset
     *
     * @param ExtendedTag $error
     * @return $this
     */
    function setError(ExtendedTag $error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Get the error HTML element for this input/fielset
     *
     * @return ExtendedTag
     */
    function getError()
    {
        return $this->error;
    }
}
