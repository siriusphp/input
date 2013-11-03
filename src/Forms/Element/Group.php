<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Html\Element as HtmlElement;

class Group extends HtmlElement {

	function getChildren () {
		return $this
			->getForm()
			->getChildrenOf($this->name);
	}
	
}