<?php

namespace Sirius\Forms\Renderer\Widget;

abstract class Input extends Base {
    /** Value of the input field
     *
     * @var mixed
     */
    protected $value;
    
    function __construct($options = array()) {
        parent::__construct($options);
    	if (isset($options['value'])) {
			$this->value($options['value']);
		}
    	if (isset($options['name'])) {
			$this->name = $options['name'];
			$this->attr('name', $options['name']);
		}
    }
    
	function value($val = null) {
		if (count(func_get_args()) === 0) {
			return $this->getValue();
		} else {
			return $this->setValue($val);
		}
	}
	
	protected function setValue($val) {
		$this->value = $val;
		return $this;
	}
	
	protected function getValue() {
		return $this->value;
	}
	
	function __toString() {
		if ($this->isSelfClosing) {
			$template = "<{$this->tag} %s value=\"%s\">";
			$value = htmlspecialchars($this->value, ENT_COMPAT);
		} else {
			$template = "<{$this->tag} %s>%s</{$this->tag}>";
			$value = $this->value;
		}
		return sprintf($template, $this->getAttributesString(), $value);
	}
}