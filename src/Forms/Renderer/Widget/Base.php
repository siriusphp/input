<?php 

namespace Sirius\Forms\Renderer\Widget;

abstract class Base extends \Sirius\Forms\Html\Element {
	/**
	 * The HTML tag vaue
	 * @var string
	 */
	protected $tag = 'input';

	/**
	 * Is the element self enclosing
	 * @var bool
	 */
	protected $isSelfClosing = true;

	/**
	 * Name of the input element / label
	 * 
	 * @var string
	 */
	protected $name;
	
	/** Value of the input field
	 * 
	 * @var mixed
	 */
	protected $value;

	static function factory($options = array()) {
		return new static($options);
	}
	
	function __construct($options = array()) {
		if (isset($options['attrs'])) {
			parent::__construct($options['attrs']);
		} else {
			parent::__construct();
		}
		if (isset($options['name'])) {
			$this->name = $name;
			$this->attr('name', $options['name']);
		}
		if (isset($options['value'])) {
			$this->value($options['value']);
		}
		if (isset($options['data'])) {
			$this->data($options['data']);
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
	
	protected function getAttributesString() {
		$result = array();
		$attrs = $this->attr();
		ksort($attrs);
		foreach ($attrs as $k => $v) {
			if ($k !== 'value') {
				$result[] = $k . '="' . htmlspecialchars($v, ENT_COMPAT) . '"';
			}
		}
		return implode(' ', $result);
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

