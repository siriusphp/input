<?php 

namespace Sirius\Forms\Renderer\Widget;

abstract class Base extends \Sirius\Forms\Html\Element {
	/**
	 * The HTML tag
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
	
	protected $before = array();
	
	protected $after = array();
	
	/**
	 * Factory method to allow for chaning since setters return the same object
	 * 
	 * @param array $options
	 * @return \Sirius\Forms\Renderer\Widget\Base
	 */
	static function factory($options = array()) {
		return new static($options);
	}
	
	function __construct($options = array()) {
		if (isset($options['attrs'])) {
			parent::__construct($options['attrs']);
		} else {
			parent::__construct();
		}
		if (isset($options['data'])) {
			$this->data($options['data']);
		}
		if (isset($options['text'])) {
			$this->text($options['text']);
		}
	}
	
	/**
	 * Return the attributes as a string for HTML output
	 * example: title="Click here to delete" class="remove"
	 * 
	 * @return string
	 */
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

	
	function before($stringOrObject) {
	    array_unshift($this->before, $stringOrObject);
	    return $this;
	}
	
	function after($stringOrObject) {
	    array_push($this->after, $stringOrObject);
	    return $this;
	}
	
	function wrap($before, $after) {
	    return $this->before($before)
	                 ->after($after);
	}
	
	function __toString() {
	    $before = '';
	    foreach ($this->before as $item) {
	        $before .= (string)$item;
	    }
		$after = '';
	    foreach ($this->after as $item) {
	        $after .= (string)$item;
	    }
	    if ($this->isSelfClosing) {
	        $template = "<{$this->tag} %s>";
	        $element = sprintf($template, $this->getAttributesString());
	    } else {
	        $template = "<{$this->tag} %s>%s</{$this->tag}>";
	        $element = sprintf($template, $this->getAttributesString(), $this->text());
	    }
	    return $before . $element . $after;
	}
}

