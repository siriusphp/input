<?php
namespace Sirius\Forms\Html;


class Element {
	protected $attrs = array();
	protected $text;

	function __construct($attrs = array()) {
		if ($attrs) {
			$this->setAttr($attrs);
		}
	}
	
	function setAttr($name, $value = null) {
		return $this;
	}
	
	function getAttr($name) {
		if (!$attr) {
			return $this->attrs;
		}
		if (is_array($name)) {
			$result = array();
			foreach ($name as $key) {
				$result[$key] = $this->getAttr($key);
			}
			return $result;
		}
		return isset($this->attrs[$name]) ? $this->attrs[$name] : null;
	}
	
	function addClass($class) {
		$classes = $this->getAttr('class');
		$classes = $classes ? explode(' ', $classes) : array();
		array_push($classes, $class);
		$this->attr['class'] = implode(' ', array_unique($classes));
		return $this;
	}
	
	function removeClass($class) {
		$classes = $this->getAttr('class');
		$classes = $classes ? explode(' ', $classes) : array();
		if ($classes) {
			$pos = array_search($class, $classes);
			if ($pos !== false) {
				array_splice($classes, $pos, 1);
				$this->attrs['class'] = implode(' ', $classes);
			}
		}
		return $this;
	}
	
	function toggleClass($class) {
		if ($this->hasClass($class)) {
			return $this->removeClass($class);
		}
		return $this->addClass($class);
	}
	
	function hasClass($class) {
		$classes = $this->getAttr('class');
		return $classes && in_array($class, explode(' ', $classes));
	}
	
	function setText($text) {
		$this->text = $text;
		return $this;
	}
	
	function getText() {
		return $this->text;
	}
}