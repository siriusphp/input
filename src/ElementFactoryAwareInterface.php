<?php

namespace Sirius\Forms;

use \Sirius\Forms\ElementFactory;

interface ElementFactoryAwareInterface {
	
    /**
     * Sets the element factory
     * 
     * @param ElementFactory $elementFactory            
     * @return self
     */
	public function setElementFactory(ElementFactory $elementFactory);
}