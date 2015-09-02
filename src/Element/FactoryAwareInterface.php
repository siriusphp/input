<?php

namespace Sirius\Input\Element;

use Sirius\Input\Element\Factory as ElementFactory;

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
