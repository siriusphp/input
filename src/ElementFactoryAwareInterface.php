<?php

namespace Sirius\Forms;

use \Sirius\Forms\ElementFactory;

interface ElementFactoryAwareInterface {
	
	public function setElementFactory(ElementFactory $elementFactory);
}