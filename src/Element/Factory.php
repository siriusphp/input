<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element\Input;
use Sirius\Forms\Element;

class Factory
{

    protected $types = array(
        'text' => '\Sirius\Forms\Element\Input\Text',
        'file' => '\Sirius\Forms\Element\Input\File',
        'textarea' => '\Sirius\Forms\Element\Input\Textarea',
        'select' => '\Sirius\Forms\Element\Input\Select',
        'multiselect' => '\Sirius\Forms\Element\Input\MultiSelect',
        'checkbox' => '\Sirius\Forms\Element\Input\Checkbox',
        'button' => '\Sirius\Forms\Element\Button',
        'submit' => '\Sirius\Forms\Element\Button\Submit',
        'reset' => '\Sirius\Forms\Element\Button\Reset'
    );

    function registerElementType($type, $classOrClosure)
    {
        if ($classOrClosure instanceof \Closure) {
            $this->types[$type] = $classOrClosure;
            return $this;
        }
        if (!is_string($classOrClosure)) {
            throw new \RuntimeException('Input type must be a class or a closure');
        }
        if (!class_exists($classOrClosure)) {
            throw new \RuntimeException(sprintf('Class %s does not exist', $classOrClosure));
        }
        if (!is_subclass_of($classOrClosure, '\Sirius\Forms\Element\Input')) {
            throw new \RuntimeException(
                sprintf('Class %s must extend the \Sirius\Forms\Element\Input class', $classOrClosure)
            );
        }
        $this->types[$type] = $classOrClosure;
        return $this;
    }

    /**
     * Create element from options
     *
     * @param $name
     * @param array $options
     * @return \Sirius\Forms\Element
     * @throws \RuntimeException
     */
    function createFromOptions($name, $options = array())
    {
        $type = 'text';
        if (isset($options[Input::ELEMENT_TYPE]) && isset($this->types[$options[Input::ELEMENT_TYPE]])) {
            $type = $options[Input::ELEMENT_TYPE];
            unset($options[Input::ELEMENT_TYPE]);
        }
        if (!isset($this->types[$type])) {
            throw new \RuntimeException('The ElementFactory does not have a default way to create elements');
        }
        /* @var $element \Sirius\Forms\Element */
        if ($this->types[$type] instanceof \Closure) {
            $element = call_user_func($this->types[$type], $name, $options);
        } else {
            $class = $this->types[$type];
            $element = new $class($name, $options);
        }

        if (!$element instanceof Element) {
            throw new \RuntimeException('Cannot create a valid form element based on the data provided');
        }

        // if the element is a fieldset/collection type, inject the element factory
        if ($element instanceof FactoryAwareInterface) {
            $element->setElementFactory($this);
        }

        return $element;
    }
}
