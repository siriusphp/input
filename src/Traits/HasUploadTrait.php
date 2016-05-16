<?php

namespace Sirius\Input\Traits;

use Sirius\Input\Specs;

trait HasUploadTrait
{

    /**
     * Returns the upload container for the element
     *
     * @return null|mixed
     */
    public function getUploadContainer()
    {
        return isset($this[Specs::UPLOAD_CONTAINER]) ? $this[Specs::UPLOAD_CONTAINER] : null;
    }

    /**
     * Sets the upload container for the elment
     *
     * @param string|\Sirius\Upload\Container\ContainerInterface $container
     *
     * @return $this
     */
    public function setUploadContainer($container)
    {
        $this[Specs::UPLOAD_CONTAINER] = $container;

        return $this;
    }

    /**
     * Get the upload options (overwrite, auto confirm, etc)
     *
     * @see \Sirius\Upload\Handler
     * @return null|array
     */
    public function getUploadOptions()
    {
        return isset($this[Specs::UPLOAD_OPTIONS]) ? $this[Specs::UPLOAD_OPTIONS] : null;
    }

    /**
     * Get the upload options (overwrite, auto confirm, etc)
     *
     * @param array $options
     *
     * @return $this
     */
    public function setUploadOptions($options = array())
    {
        $this[Specs::UPLOAD_OPTIONS] = $options;

        return $this;
    }

    /**
     * Get the validation rules for the uploaded file(s)
     *
     * @return null|array
     */
    public function getUploadRules()
    {
        return isset($this[Specs::UPLOAD_RULES]) ? $this[Specs::UPLOAD_RULES] : null;
    }

    /**
     * Sets the validation rules for the uploaded file(s)
     *
     * @param array $rules
     *
     * @return $this
     */
    public function setUploadRules($rules = array())
    {
        $this[Specs::UPLOAD_RULES] = $rules;

        return $this;
    }
}
