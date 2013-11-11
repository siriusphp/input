<?php

namespace Sirius\Forms\Renderer\Widget;

class Select extends Input {
	protected $tag = 'select';
	protected $isSelfClosing = false;

	protected function getOptionsString() {
		$value = $this->value();
		$options = '';
		if ($this->data('first_option')) {
			$options .= sprintf('<option value="">%s</option>', $this->data('first_option'));
		}
		foreach ($this->data('options') as $k => $v) {
			$selected = '';
			if ((is_string($value) && $k == $value)
				|| (is_array($value) && in_array($k, $value))) {
				$selected = 'selected="selected"';
			}
			$options .= sprintf('<option value="%s" %s>%s</option>', htmlentities($k, ENT_COMPAT), $selected, $v);		
		}
		return $options;
	}
	
	function __toString() {
		$template = '<select %s>%s</select>';
		return sprintf($template, $this->getAttributesString(), $this->getOptionsString());
	}
}