<?php

namespace Sirius\Renderer\Widget;

use Sirius\Forms\Html\ExtendedTag;

class Base extends ExtendedTag {
    protected $label;
    protected $error;
    protected $hint;
    protected $input;    
    
    function setLabel(ExtendedTag $label) {
        $this->label = $label;
        return $this;
    }
    
    function getLabel() {
        return $this->label;
    }
    
    function setHint(ExtendedTag $hint) {
        $this->hint = $hint;
        return $this;
    }
    
    function getHint() {
        return $this->hint;
    }
    
    
    function setError(ExtendedTag $error) {
        $this->error = $error;
        return $this;
    }
    
    function getError() {
        return $this->error;
    }
    
    function setInput(ExtendedTag $input) {
        $this->input = $input;
        return $this;
    }
    
    function getInput() {
        return $this->input;
    }
    
    function render() {
        $error = $this->getError() && $this->getError()->text() ? $this->getError() : '';
        $label = $this->getLabel() && $this->getLabel()->text() ? $this->getLabel() : '';
        $hint = $this->getHint() && $this->getHint()->text() ? $this->getError() : '';
        $input = $this->getInput();
        $this->setText("{$error}{$label}{$input}{$hint}");
        return parent::render();
    }
    
}