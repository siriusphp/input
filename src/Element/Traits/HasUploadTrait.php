<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;

trait HasUploadTrait {

    function getUploadContainer() {
        return isset($this[Input::UPLOAD_CONTAINER]) ? $this[Input::UPLOAD_CONTAINER] : null;
    }

    function setUploadContainer($container) {
        $this[Input::UPLOAD_CONTAINER] = $container;
        return $this;
    }

    function getUploadOptions() {
        return isset($this[Input::UPLOAD_OPTIONS]) ? $this[Input::UPLOAD_OPTIONS] : null;
    }

    function setUploadOptions($options = array()) {
        $this[Input::UPLOAD_OPTIONS] = $options;
        return $this;
    }

    function getUploadRules() {
        return isset($this[Input::UPLOAD_RULES]) ? $this[Input::UPLOAD_RULES] : null;
    }

    function setUploadRules($rules = array()) {
        $this[Input::UPLOAD_RULES] = $rules;
        return $this;
    }
}
