<?php

namespace Sirius\Forms\Renderer\Widget;

class Text extends Input {
	protected $tag = 'input';
	protected $isSelfClosing = true;
	
	protected function setValue($val) {
		parent::setValue($val);
		$this->attr('value', $val);
		return $this;
	}
	
}