<?php
namespace Sirius\Forms\Element;

class Factory
{

    protected $types = array(
        'text' => '\Sirius\Forms\Element\Input\Text',
        'textarea' => '\Sirius\Forms\Element\Input\Textarea',
        'select' => '\Sirius\Forms\Element\Input\Select',
        'checkbox' => '\Sirius\Forms\Element\Input\Checkbox',
        'checkboxset' => '\Sirius\Forms\Element\Input\CheckboxSet',
        'radio' => '\Sirius\Forms\Element\Input\Radio',
        'radioset' => '\Sirius\Forms\Element\Input\RadioSet',
        'button' => '\Sirius\Forms\Element\Input\Button',
        'submit' => '\Sirius\Forms\Element\Input\Submit',
        'reset' => '\Sirius\Forms\Element\Input\Reset'
    );

    function registerElementType($type, $classOrClosure)
    {
        if ($classOrClosure instanceof \Closure) {
            $this->types[$type] = $classOrClosure;
            return $this;
        }
        if (! is_string($classOrClosure)) {
            throw new \RuntimeException('Element type must be a class or a closure');
        }
        if (! class_exists($classOrClosure)) {
            throw new \RuntimeException(sprintf('Class %s does not exist', $classOrClosure));
        }
        if (! is_subclass_of($classOrClosure, '\Sirius\Forms\Element\Input')) {
            throw new \RuntimeException(sprintf('Class %s must extend the \Sirius\Forms\Element\Input class', $classOrClosure));
        }
        $this->types[$type] = $classOrClosure;
        return $this;
    }

    /**
     * Create element from specification
     * 
     * @param array $specs
     * @throws \RuntimeException
     * @return Sirius\Forms\Element
     */
    function createFromSpecs($name, $specs = array())
    {
        $type = 'text';
        if (isset($specs[Input::ELEMENT_TYPE]) && isset($this->types[$specs[Input::ELEMENT_TYPE]])) {
            $type = $specs[Input::ELEMENT_TYPE];
            unset($specs[Input::ELEMENT_TYPE]);
        }
        if (! isset($this->types[$type])) {
            throw new \RuntimeException('The ElementFactory does not have a default way to create elements');
        }
        if ($this->types[$type] instanceof \Closure) {
            $element = call_user_func($this->types[$type], $name, $specs);
        } else {
            $class = $this->types[$type];
            $element = new $class($name, $specs);
        }
        
        // if the element is a fieldset/collection type, inject the element factory
        if ($element instanceof \Sirius\Forms\ElementFactoryAwareInterface) {
            $element->setElementFactory($this);
        }
        
        return $element;
    }
}