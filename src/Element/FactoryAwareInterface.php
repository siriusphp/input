<?php

namespace Sirius\Forms\Element;

use Sirius\Forms\Element\Factory as ElementFactory;

interface FactoryAwareInterface
{

    /**
     * Sets the element factory
     *
     * @param ElementFactory $elementFactory
     * @return self
     */
    public function setElementFactory(ElementFactory $elementFactory);
}
