<?php

namespace Sirius\Forms\Renderer\Widget;

use Sirius\Forms\Renderer\Widget\Base;

class Text extends Base {
	protected $tag = 'input';
	protected $isSelfClosing = true;
	
	protected function setValue($val) {
		parent::setValue($val);
		$this->attr('value', $val);
		return $this;
	}
	
}