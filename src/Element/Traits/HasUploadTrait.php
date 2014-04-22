<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;

trait HasUploadTrait
{

    /**
     * Returns the upload container for the element
     *
     * @return null|mixed
     */
    function getUploadContainer()
    {
        return isset($this[ Input::UPLOAD_CONTAINER ]) ? $this[ Input::UPLOAD_CONTAINER ] : null;
    }

    /**
     * Sets the upload container for the elment
     *
     * @param string|\Sirius\Upload\Container\ContainerInterface $container
     *
     * @return $this
     */
    function setUploadContainer($container)
    {
        $this[ Input::UPLOAD_CONTAINER ] = $container;
        return $this;
    }

    /**
     * Get the upload options (overwrite, auto confirm, etc)
     *
     * @see \Sirius\Upload\Handler
     * @return null|array
     */
    function getUploadOptions()
    {
        return isset($this[ Input::UPLOAD_OPTIONS ]) ? $this[ Input::UPLOAD_OPTIONS ] : null;
    }

    /**
     * Get the upload options (overwrite, auto confirm, etc)
     *
     * @param array $options
     *
     * @return $this
     */
    function setUploadOptions($options = array())
    {
        $this[ Input::UPLOAD_OPTIONS ] = $options;
        return $this;
    }

    /**
     * Get the validation rules for the uploaded file(s)
     *
     * @return null|array
     */
    function getUploadRules()
    {
        return isset($this[ Input::UPLOAD_RULES ]) ? $this[ Input::UPLOAD_RULES ] : null;
    }

    /**
     * Sets the validation rules for the uploaded file(s)
     *
     * @param array $rules
     *
     * @return $this
     */
    function setUploadRules($rules = array())
    {
        $this[ Input::UPLOAD_RULES ] = $rules;
        return $this;
    }
}
