<?php
namespace Sirius\Forms\Widget\Traits;

use Sirius\Forms\Html\ExtendedTag;

trait HasErrorTrait
{

    protected $error;

    function setError(ExtendedTag $error)
    {
        $this->error = $error;
        return $this;
    }

    function getError()
    {
        return $this->error;
    }
}