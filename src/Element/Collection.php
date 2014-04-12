<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element\ContainerTrait as ElementContainerTrait;
use Sirius\Forms\Element\Factory as ElementFactory;
use Sirius\Forms\Form;

class Collection extends Input
{
    use ElementContainerTrait;

    /**
     *
     * @var \Sirius\Form\ElementFactory
     */
    protected $elementFactory;

    protected function getDefaultSpecs()
    {
        return $defaultSpecs = array(
            Input::WIDGET => 'fieldset'
        );
    }

    /**
     * Generate the namespaced field name of an element inside the fielset
     *
     * @param string $name
     * @return string
     */
    protected function getFullChildName($name)
    {
        $firstOpenBracket = strpos($name, '[');
        // the name is already at least 2 levels deep like street[name]
        if ($firstOpenBracket !== false) {
            $name = substr($name, 0, $firstOpenBracket) . '][' . substr($name, $firstOpenBracket + 1, -1);
        }
        return $this->getName() . '[*][' . $name . ']';
    }

    function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;
        return $this;
    }

    /**
     * Add an element to the fielset
     *
     * @param string $name
     * @param \Sirius\Forms\Element|array $elementOrOptions
     * @throws \RuntimeException
     * @return self
     */
    function add($name, $elementOrOptions)
    {
        $name = $this->getFullChildName($name);
        $element = $elementOrOptions;
        if (is_array($elementOrOptions)) {
            $element = $this->elementFactory->createFromOptions($name, $elementOrOptions);
            $element->setForm($this);
        }
        return $this->addToElementContainer($name, $element);
    }

    /**
     * Retrieve an element by name
     *
     * @param string $name
     * @return \Sirius\Forms\Element
     */
    function get($name)
    {
        $name = $this->getFullChildName($name);
        return $this->getFromElementContainer($name);
    }

    /**
     * Removes an element from the fielset
     *
     * @param string $name
     * @throws \RuntimeException
     * @return Form
     */
    function remove($name)
    {
        $name = $this->getFullChildName($name);
        return $this->removeFromElementContainer($name);
    }

    /**
     * Returns whether an element exist in the fielset
     *
     * @param string $name
     * @return boolean
     */
    function has($name)
    {
        return false !== $this->get($name);
    }

    function prepareForm(Form $form)
    {
        parent::prepareForm($form);
        foreach ($this->getChildren() as $element) {
            $element->prepareForm($form);
        }
    }
}
