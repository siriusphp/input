<?php
namespace Sirius\Forms\Html;


class Element {
	protected $attrs = array();
	protected $data = array();
	protected $text;

	function __construct($attrs = array()) {
		if ($attrs) {
			$this->setAttr($attrs);
		}
	}
	
	function attr($name, $value = null) {
		if (count(func_get_args()) == 0) {
			return $this->getAttr();
		}
		if (is_array($name)) {
			if (range(0, count($name) - 1) == array_keys($name)) {
				return $this->getAttr($name);
			} else {
				return $this->setAttr($name);
			}
		}
		if (is_string($name)) {
			if (count(func_get_args()) == 1) {
				return $this->getAttr($name);
			} else {
				return $this->setAttr($name, $value);
			}
		}
		throw new \InvalidArgumentException('The attr() method did not receive the proper arguments');
	}
	
	protected function setAttr($name, $value = null) {
		if (is_array($name)) {
			foreach ($name as $k => $v) {
				$this->attrs[$k] = $v;
			}
		} elseif (is_string($name)) {
			if ($value === null
				&& isset($this->attrs[$name])) {
				unset($this->attrs[$name]);
			} elseif ($value !== null) {
				$this->attrs[$name] = $value;
			}
		}
		return $this;
	}
	
	protected function getAttr($name) {
		if (count(func_get_args()) === 0) {
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
		if (!$this->hasClass($class)) {
			$this->attr('class', trim((string) $this->attr('class') . ' ' . $class));
		}
		return $this;
	}
	
	function removeClass($class) {
		$classes = $this->attr('class');
		if ($classes) {
			$classes = preg_replace('/(^| ){1}' . $class . '( |$){1}/i', ' ', $classes);
			$this->attr('class', $classes);
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
		return $classes && ((bool) preg_match('/(^| ){1}' . $class . '( |$){1}/i', $classes));
	}
	
	function text($text = null) {
		if (count(func_get_args()) === 0) {
			return $this->getText();
		}
		return $this->setText($text);
	}
	
	protected function setText($text) {
		$this->text = $text;
		return $this;
	}
	
	protected function getText() {
		return $this->text;
	}

	/**
	 * Set/Get data attached to this element
	 * @param string|array $name
	 * @param mixed $value
	 * @return array|mixed
	 */
	function data($name, $value = null) {
		if (count(func_get_args()) == 0) {
			return $this->getData();
		}
		if (is_array($name)) {
			if (range(0, count($name) - 1) == array_keys($name)) {
				return $this->getData($name);
			} else {
				return $this->setData($name);
			}
		}
		if (is_string($name)) {
			if (count(func_get_args()) == 1) {
				return $this->getData($name);
			} else {
				return $this->setData($name, $value);
			}
		}
		throw new \InvalidArgumentException('The data() method did not receive the proper arguments');
	}
	
	protected function getData($key) {
		if (is_string($key)) {
			if (isset($this->data[$key])) {
				return $this->data[$key];
			} else {
				return null;
			}
		} elseif (is_array($key)) {
			$data = array();
			foreach ($key as $k) {
				if (isset($this->data[$k])) {
					$data[$k] = $this->data[$k];
				} else {
					$data[$k] = null;
				}
			}
			return $data;
		}
		return $this->data;
	}
	
	protected function setData($name, $value = null) {
		if (is_array($name)) {
			foreach ($name as $k => $v) {
				$this->data[$k] = $v;
			}
		} elseif (is_string($name)) {
			if ($value === null
				&& isset($this->data[$name])) {
				unset($this->data[$name]);
			} elseif ($value !== null) {
				$this->data[$name] = $value;
			}
		}
		return $this;
	}
	
}